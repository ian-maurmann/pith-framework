# Route–Action–View workflow

The Route–Action–View (RAV) workflow pipeline is how a request moves from URL match through render. A [Route List](workflow/route-lists.md) maps the HTTP method and path to a [Route](workflow/routes.md). The Route wires a [Pack](workflow/packs.md), access, [Action](workflow/actions.md), [Preparer](workflow/preparers.md), [View Requisition](workflow/view-requisitions.md), [View Adapter](workflow/view-adapters.md), and [View](workflow/views.md). `PithDispatcher` runs those pieces in order.

“RAV” names the main layers—Route, Action, and View. Pack, Access, Preparer, View Requisition, and View Adapter are the supporting taps on the same pipeline. There is no combined framework class named “RouteActionView.” The name describes the layering convention: configuration and plain PHP classes built by PHP-DI.

Domain work under an Action (Services, Gateways, Utilities) is a separate stack. See the [Action–Service–Gateway workflow](action-service-gateway-workflow.md). For how RAV and ASG join—philosophy, wiring, and benefits—see the [combined RAV–ASG workflow](rav-asg-workflow.md).

## Role in the stack

**Normal path** (non-resource Route):

```
Route List → Route → Pack → Access → Action → Preparer → View Requisition → Responder → View Adapter (View)
```

| Layer | Responsibility |
|-------|----------------|
| **Route List** | Maps HTTP method + path to a Route FQCN (or nested Route List) |
| **Route** | Workflow config; wires Pack, access, Action, Preparer, view pieces, and options |
| **Pack** | Feature-folder marker; supplies `[^pack_folder]` for path expressions |
| **Access** | Named access level or access-level class; gate before Action |
| **Action** | Request-facing logic; fills `$this->prepare` |
| **Preparer** | Shapes `$prepare` → `$view` variables for the adapter |
| **View Requisition** | Declares HTTP headers and front-end resources (CSS, JS, preloads) |
| **Responder** | Registers requisition resources (partials may insert immediately) |
| **View Adapter** | Resolves the `$view` path and renders the response |
| **View** | Path expression + Preparer variables + adapter (+ requisition); not a separate class |

Static `resource-folder` / `resource-file` Routes skip Action → Preparer → View. Pages with `$layout` set dispatch the layout Route with the page Route as content.

## How a request uses the pipeline

1. `$engine->start()` loads config. `PithRouter` matches the request against [Route Lists](workflow/route-lists.md) and returns a [Route](workflow/routes.md) FQCN.
2. PHP-DI builds the `PithRoute`. FastRoute path params become `route_parameters`. `PithDispatcher::dispatch($route)` branches on `$route_type`.
3. For a normal Route, the dispatcher loads the [Pack](workflow/packs.md), checks [Access Levels](workflow/access-levels.md), and runs the [Action](workflow/actions.md). The Action writes results onto `$this->prepare` (often via Services—see [ASG](action-service-gateway-workflow.md)).
4. The [Preparer](workflow/preparers.md) reads `$prepare` and shapes variables onto `$view` for the adapter.
5. The [View Requisition](workflow/view-requisitions.md) adds headers and front-end resources. The Responder registers them.
6. The [View Adapter](workflow/view-adapters.md) resolves the [View](workflow/views.md) path (`[^route_folder]` / `[^pack_folder]`), receives the Preparer variables and resources, and calls `run()` to produce the response.

For dispatcher details and route types, see [Routes](workflow/routes.md).

## Defaults and wiring

The Route holds FQCNs (and the view path). Listing them on the Route is enough—there is no separate registry. PHP-DI builds each class. Defaults on `PithRoute` cover the optional pieces:

| Property | Default |
|----------|---------|
| `$action` | `EmptyAction` |
| `$preparer` | `PassThroughPreparer` |
| `$view_requisition` | `EmptyViewRequisition` |
| `$view_adapter` | Latte adapter |

View and resource paths are expressions: `[^route_folder]` (directory of the Route class file) and `[^pack_folder]` (directory of the Pack class file).

Routes can also run without a URL rematch via `$engine->runPartial()`, `runLayout()`, `runRoute()`, or `runTaskRoute()`.

## Conventions

- Name classes `*Route`, `*PartialRoute`, `*LayoutRoute`, `*RouteList`, `*Pack`, `*Action`, `*Preparer`, `*ViewRequisition` as fits the role.
- Always set `$route_type`, `$pack`, and `$access_level` on a Route.
- Prefer `[^route_folder]` for views and resources that live beside the Route.
- Use double-backslash FQCNs in PHP strings (`'\\Pith\\...'`).
- Keep workflow classes PSR-4 autoloadable; listing a Route in a Route List (or type-hinting a dependency) is registration.
- Keep HTTP/view concerns on the RAV pipeline; keep domain rules under Actions via the [ASG](action-service-gateway-workflow.md) stack.

## Related pieces

| Piece | Role |
|-------|------|
| [Packs](workflow/packs.md) (`PithPack`) | Feature-folder marker; supplies pack folder |
| [Route Lists](workflow/route-lists.md) (`PithRouteList`) | Maps URLs to Route FQCNs |
| [Routes](workflow/routes.md) (`PithRoute`) | Wires the pipeline for a matched (or programmatically run) request |
| [Actions](workflow/actions.md) (`PithAction`) | Request-facing logic; fills `$prepare` |
| [Preparers](workflow/preparers.md) (`PithPreparer`) | Shapes `$prepare` → `$view` |
| [View Requisitions](workflow/view-requisitions.md) (`PithViewRequisition`) | Headers and front-end resources |
| [View Adapters](workflow/view-adapters.md) | Render backends selected by `$view_adapter` |
| [Views](workflow/views.md) | Path + variables + adapter (+ requisition) |
| [Access Levels](workflow/access-levels.md) | Route `$access_level` gate |
| [Action–Service–Gateway workflow](action-service-gateway-workflow.md) | Domain stack under Actions |
