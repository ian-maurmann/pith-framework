# Combined RAV–ASG workflow

The Route–Action–View (RAV) and Action–Service–Gateway (ASG) pipelines are two stacked conventions that meet at the [Action](workflow/actions.md). RAV moves a request from URL match through render. ASG runs domain work under that Action. Together they form the full request path: match and access, request-facing logic, business rules and data access, then prepare and view.

There is no combined framework class named “RavAsg” or similar. The names describe layering conventions: a [Route](workflow/routes.md) configures the request pipeline; PHP-DI builds plain PHP classes; constructors wire the domain stack. For pipeline detail, see the [Route–Action–View workflow](route-action-view-workflow.md) and the [Action–Service–Gateway workflow](action-service-gateway-workflow.md).

## RAV–ASG Philosophy

Two pipelines keep HTTP/view concerns apart from domain and SQL concerns.

- **RAV** owns URL match, access, request-facing logic, prepare/view shaping, and render. Pack, Access, Preparer, View Requisition, and View Adapter are supporting taps on that same pipeline.
- **ASG** owns business rules, validation, orchestration, transactions, SQL (via Gateways), and pure helpers (via Utilities). Services, Gateways, Utilities, and Repositories are **not** workflow elements—Routes never list them.
- The **Action is the hinge**. The dispatcher runs it as part of RAV. The Action calls Services as part of ASG. Results re-enter RAV back at the Action and are given to `$this->prepare` for the Preparer and View.
- Routes never know about Services or Gateways. Services never know about Routes or Views. Naming is convention only—there is no `RouteActionView` or `ActionServiceGateway` class.

That split is deliberate: the Route stays a config object, domain logic stays testable without a full HTTP pass, and view adapters or access levels can change without rewriting business rules.

## Combined flow

**Default path** (normal non-resource Route with domain work):

```
Route List → Route → Pack → Access → Action → Service → Gateway → DB wrapper (PDO)
                                              ↓           ↘
                                         Preparer      Utility
                                              ↓
                                   View Requisition → Adapter → View
```

The Action sits in both stacks:

```
┌──────────────────────── RAV (dispatcher taps) ────────────────────────┐
│  Route List → Route → Pack → Access → ACTION → Preparer → … → View   │
└──────────────────────────────────┬────────────────────────────────────┘
                                   │ PHP-DI constructor injection
                                   ▼
                    ┌──────────── ASG ────────────┐
                    │  Action → Service → Gateway │
                    │              ↘ Utility      │
                    └─────────────────────────────┘
```

| Layer | Pipeline | Responsibility |
|-------|----------|----------------|
| **Route List** | RAV | Maps HTTP method + path to a Route FQCN |
| **Route** | RAV | Workflow config; wires Pack, access, Action, Preparer, view pieces |
| **Pack** | RAV | Feature-folder marker; supplies `[^pack_folder]` |
| **Access** | RAV | Gate before Action |
| **Action** | RAV + ASG | Request-facing logic; calls Services; fills `$this->prepare` |
| **Service** | ASG | Business rules, validation, orchestration, transactions |
| **Gateway** | ASG | SQL for one table (or a small related set) |
| **Utility** | ASG | Transforms / validation / helpers; no SQL |
| **Preparer** | RAV | Shapes `$prepare` → `$view` |
| **View Requisition** | RAV | Headers and front-end resources |
| **View Adapter / View** | RAV | Resolve path and render |

**Complicated features** may insert a [Repository](workflow/repositories.md) between Service and Gateway. Repositories are planned and not yet in the framework—today Services call Gateways directly.

### How a request uses both pipelines

1. `$engine->start()` loads config. `PithRouter` matches the request against [Route Lists](workflow/route-lists.md) and returns a [Route](workflow/routes.md) FQCN.
2. PHP-DI builds the Route. `PithDispatcher` loads the [Pack](workflow/packs.md), checks [Access Levels](workflow/access-levels.md), and runs the [Action](workflow/actions.md).
3. The Action reads request input, calls one or more [Services](workflow/services.md) (injected by PHP-DI), and writes results onto `$this->prepare`.
4. Each Service applies domain rules. It may call [Utilities](workflow/utilities.md) and [Table Gateways](workflow/table-gateways.md). Gateways talk to the DB wrapper (PDO).
5. The [Preparer](workflow/preparers.md) shapes `$prepare` into `$view` variables. The [View Requisition](workflow/view-requisitions.md) adds headers and resources. The [View Adapter](workflow/view-adapters.md) renders the [View](workflow/views.md).

Static `resource-folder` / `resource-file` Routes skip Action → Preparer → View. The same Action → Preparer → View path applies across `page`, `partial`, `endpoint`, `layout`, and `task` / `job` route types.

## Wiring

### RAV wiring

The Route holds FQCNs (and the view path). Listing them on the Route is enough—there is no separate registry. `PithDispatcher` runs taps in order: Pack → Access → Action → Preparer → View Requisition → Responder → View.

```php
class HomeRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\FooOrganization\\FooProject\\FooPack';
    public string $access_level     = 'world';
    public string $action           = '\\FooOrganization\\FooProject\\HomeAction';
    public string $view             = '[^route_folder]/home-view.latte';
    public string $layout           = '\\FooOrganization\\FooProject\\MainLayoutRoute';
}
```

Defaults on `PithRoute` cover optional pieces: `EmptyAction`, `PassThroughPreparer`, `EmptyViewRequisition`, and the Latte adapter. List the Route FQCN in a Route List (or run it via `runPartial()` / `runRoute()` / `runTaskRoute()`).

### ASG wiring

Actions inject Services; Services inject Gateways and Utilities. Constructor type-hints plus PSR-4 autoloading are registration—PHP-DI builds the graph. Prefer Action → Service → Gateway; never Action → Gateway.

```php
class QuotesAction extends PithAction
{
    private QuoteService $quote_service;

    public function __construct(QuoteService $quote_service)
    {
        $this->quote_service = $quote_service;
    }

    public function runAction()
    {
        $this->prepare->quotes = $this->quote_service->getQuotes();
    }
}
```

Current packs keep the domain stack next to the feature tree (`services/`, `gateways/`, `utilities/`). Map those folders into the pack namespace with PSR-4.

### Handoff back to the view

After the Action finishes, RAV continues: `$this->prepare` → Preparer → `$view` → View Adapter `run()`. Domain results never bypass that handoff into the template layer.

## Benefits

- **Separation of concerns** — HTTP and view stay on RAV; business rules and SQL stay on ASG.
- **Thin Routes** — The Route is workflow config, not a fat controller. Listing FQCNs (and constructor type-hints for domain classes) is registration; there are no separate Service/Gateway registries.
- **Testable domain** — Services and Gateways can be exercised without the full request pipeline.
- **Feature locality** — Packs co-locate RAV pieces and ASG classes; `[^route_folder]` / `[^pack_folder]` keep paths next to the feature.
- **Graceful defaults** — `EmptyAction`, `PassThroughPreparer`, and `EmptyViewRequisition` keep simple pages thin.
- **Independent swap points** — Change view adapters or access levels without touching business rules; keep SQL in Gateways while Services own transactions and multi-step work.
- **Shared path across route types** — Pages, partials, endpoints, and tasks reuse the same Action → Preparer → View sequence.
- **Escape hatch for complexity** — A planned Repository layer can sit between Service and Gateway when data-access plumbing would otherwise bloat the Service—without forcing that middle layer on simple features.

## Related pieces

| Piece | Role |
|-------|------|
| [Route–Action–View workflow](route-action-view-workflow.md) | RAV pipeline detail |
| [Action–Service–Gateway workflow](action-service-gateway-workflow.md) | ASG stack detail |
| [Route Lists](workflow/route-lists.md) | Maps URLs to Route FQCNs |
| [Routes](workflow/routes.md) | Wires the RAV pipeline |
| [Packs](workflow/packs.md) | Feature tree for RAV pieces and often ASG folders |
| [Actions](workflow/actions.md) | Hinge between RAV and ASG; fills `$prepare` |
| [Services](workflow/services.md) | Business logic under Actions |
| [Table Gateways](workflow/table-gateways.md) | SQL / table access |
| [Utilities](workflow/utilities.md) | Transforms / helpers; no SQL |
| [Preparers](workflow/preparers.md) | Shapes `$prepare` → `$view` |
| [Views](workflow/views.md) / [View Adapters](workflow/view-adapters.md) | Render |
| [Access Levels](workflow/access-levels.md) | Route `$access_level` gate |
