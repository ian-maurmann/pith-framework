# Action–Service–Gateway workflow

The Action–Service–Gateway (ASG) workflow pipeline is how domain work runs under an [Action](workflow/actions.md). An Action takes the request, calls a [Service](workflow/services.md) for business logic, and the Service talks to [Table Gateways](workflow/table-gateways.md) (and [Utilities](workflow/utilities.md)) for data access and helpers. Results flow back into `$this->prepare` for the Preparer and View.

Services, Gateways, Utilities, and [Repositories](workflow/repositories.md) are **not** workflow elements. They sit below Actions, outside the Route → Pack → Access → Action → Preparer → View pipeline. [Routes](workflow/routes.md) wire Actions; they never touch Services or Gateways. Actions inject Services; Services inject Gateways and Utilities.

There is no combined framework class named “ActionServiceGateway.” The name describes the layering convention: plain PHP classes built by PHP-DI.

## Role in the stack

**Default path** (what the framework uses today):

```
Route List → Route → Pack → Access → Action → Service → Gateway → DB wrapper (PDO)
                                              ↓           ↘
                                         Preparer      Utility
                                              ↓
                                            View
```

**Complicated features** may insert a [Repository](workflow/repositories.md) between Service and Gateway so data-access plumbing does not bloat the Service:

```
Route List → Route → Pack → Access → Action → Service → Repository → Gateway → DB wrapper (PDO)
                                              ↓
                                         Preparer → View
```

> **Repository status:** Repositories are a planned object type. They are not yet added to this framework. Today, and for simple features going forward, Services call Gateways directly. Add a Repository only when a feature’s data access would otherwise bloat the Service.

| Layer | Responsibility |
|-------|----------------|
| **Action** | Request-facing logic; fills `$this->prepare` |
| **Service** | Business rules, validation, orchestration, transactions |
| **Repository** | Optional data-access façade for complicated features (planned); calls one Gateway, or a few for closely related tables |
| **Gateway** | SQL for one table (or a small related set) |
| **Utility** | Transforms, validation, and helpers (no SQL, no Gateways) |
| **DB wrapper** | PDO connection, `query()`, transactions |

Keep HTTP and view concerns out of Services, Gateways, Utilities, and Repositories. Keep SQL out of Services and Actions—call Gateways for that. Actions should call Services, not Gateways or Repositories.

## How a request uses the stack

1. The dispatcher matches a path, builds the [Route](workflow/routes.md), checks access, and runs the Route’s [Action](workflow/actions.md).
2. The Action reads request input, calls one or more [Services](workflow/services.md), and writes results onto `$this->prepare`.
3. The Service applies domain rules. It may call [Utilities](workflow/utilities.md) to normalize or validate data, and [Table Gateways](workflow/table-gateways.md) to run SQL. Multi-step writes and transactions live on the Service.
4. The Gateway uses `PithPostgresWrapper` (or another DB wrapper) to query a single table and returns rows, IDs, or scalars.
5. After the Action finishes, the Preparer shapes `$prepare` for the View.

For the full dispatcher order (Route List → Pack → Access → Action → Preparer → View), see [Routes](workflow/routes.md).

## Pack layout

Current packs keep the domain stack next to the feature tree:

| Folder | Holds |
|--------|-------|
| `services/` | `*Service` classes |
| `gateways/` | `*Gateway` classes |
| `utilities/` | `*Utility` (and role-named helpers) |
| `repositories/` | Planned `*Repository` classes for complicated features |

Map those folders into the pack namespace with PSR-4 so PHP-DI can autowire constructor type-hints. There is no Service, Gateway, Utility, or Repository registry.

Older packs sometimes co-locate Service + Gateway under a feature `model/` folder. App Pack scaffolds include a `services/` folder.

## Conventions

- Name classes `*Action`, `*Service`, `*Gateway`, `*Utility`, and (when used) `*Repository`.
- Inject down the stack through constructors (PHP-DI): Action → Service → Gateway / Utility; or Action → Service → Repository → Gateway.
- Prefer Service → Gateway for simple features; use Service → Repository → Gateway only when the middle layer keeps the Service lean.
- Put business rules and transactions in Services; put SQL in Gateways; put pure transforms in Utilities.
- Prefer structured info arrays with `fail_reason` and yes/no (`'yes'` / `'no'`) flags for domain outcomes.
- Keep domain classes PSR-4 autoloadable; type-hinting them on a constructor is registration.

## Related pieces

| Piece | Role |
|-------|------|
| [Actions](workflow/actions.md) (`PithAction`) | Request-facing logic; injects Services; fills `$prepare` |
| [Services](workflow/services.md) (`*Service`) | Business logic; calls Gateways and Utilities |
| [Repositories](workflow/repositories.md) (`*Repository`) | Planned optional data façade between Service and Gateway |
| [Utilities](workflow/utilities.md) (`*Utility`) | Transforms / validation / helpers; no SQL |
| [Table Gateways](workflow/table-gateways.md) (`*Gateway`) | SQL / table access |
| [Routes](workflow/routes.md) | Wire Action FQCNs; never touch Services or Gateways |
| [Packs](workflow/packs.md) (`PithPack`) | Feature tree that often contains `services/`, `gateways/`, and `utilities/` |
| `PithPostgresWrapper` | Current Postgres PDO wrapper (transactions from Services) |
