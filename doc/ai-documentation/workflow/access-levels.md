# Access Levels

Access Levels are the workflow authorization gate. Each [Route](routes.md) sets `$access_level` to a named string or an Access Level class FQCN. `PithAccessControl` resolves that value to a `PithAccessLevel` object; `PithDispatcher` calls `checkAccess()` before the Action runs.

There is no separate middleware stack, and Access Levels are not a full RBAC system. One level gates one Route: “may this request run this Route?”

## Where access is set

`$access_level` is **required on the Route**. Packs and Actions inherit `$access_level` from `PithWorkflowElement`, but the engine does **not** enforce it when loading a Pack or running an Action. Secure the Route—see [Packs](packs.md).

```php
class HomeRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\FooOrganization\\FooProject\\FooPack';
    public string $access_level = 'world';
    public string $action       = '\\FooOrganization\\FooProject\\HomeAction';
    public string $view         = '[^route_folder]/home-view.latte';
    public string $layout       = '\\FooOrganization\\FooProject\\MainLayoutRoute';
}
```

## When access runs

`PithDispatcher` checks access twice for a normal request:

1. **Early** — at the start of `dispatch()`, before headers and type branching (so denied requests can redirect before later header work).
2. **In the workflow** — inside the Route pipeline tap (`tapAccess`), for pages, layouts, partials, endpoints, tasks, and resource Routes.

**Pages with a layout:** the page Route is checked, then the layout Route is dispatched and checked as well. Both must allow access. Layouts are often `'world'` while the page is stricter—or both use the same elevated level.

## Base type

Access Level classes extend `Pith\Workflow\PithAccessLevel` and implement `isAllowedToAccess(): bool`. The base class defaults to deny:

```php
class PithAccessLevel
{
    public function getName(): string
    {
        return 'NOT NAMED';
    }

    public function isAllowedToAccess(): bool
    {
        return false;
    }
}
```

Named aliases (`'world'`, `'user'`, …) are hard-mapped in `PithAccessControl::getAccessLevel()`. Any other string is treated as a DI-resolvable FQCN.

## Built-in named levels

| Name | Class | Behavior |
|------|--------|----------|
| `none` | *(no object)* | Always deny |
| `world` | `WorldAccessLevel` | Always allow |
| `dev-ip` | `DevIpAccessLevel` | Client IP is in `PITH_APP_DEV_ACCESS_IP_ADDRESSES` |
| `cron-ip` | `CronIpAccessLevel` | Client IP is in `PITH_APP_CRON_ACCESS_IP_ADDRESSES` |
| `task` | `TaskAccessLevel` | Task-tool process **or** cron IP whitelist |
| `user` | `UserAccessLevel` | Logged-in session type `user` |
| `webmaster` | `WebmasterAccessLevel` | Logged-in user with `'webmaster'` in session access levels |
| `internal` | `InternalAccessLevel` | Logged-in user treated as internal (currently same as webmaster) |
| `perform-user-login` | `PerformUserLoginAccessLevel` | Side effect: attempt login from POST; typically redirects and returns `false` |
| `perform-user-logout` | `PerformUserLogoutAccessLevel` | Side effect: logout + redirect from token |
| `logout` | `LogoutAccessLevel` | Side effect: logout with token; returns `true` and sets a registry note |

**DB-seeded but not implemented as workflow classes:** `moderator`, `dev`, and `admin` exist in `pith_access_levels` but have no built-in Access Level classes. Use a custom FQCN (or add a named mapping) if you need those as Route gates.

### Common choices

| Use | Level |
|-----|--------|
| Public pages and static resources | `'world'` |
| Logged-in-only pages | `'user'` |
| Panel / organization tools | `'internal'` or `'webmaster'` |
| Background jobs / CLI tasks | `'task'` |
| Local demo or env-restricted pages | `'dev-ip'` |
| Login POST handler | `'perform-user-login'` |
| Logout handler | `'perform-user-logout'` |

```php
class UserPageRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\FooOrganization\\FooProject\\FooPack';
    public string $access_level = 'user';
    public string $action       = '\\FooOrganization\\FooProject\\UserPageAction';
    public string $view         = '[^route_folder]/user-page-view.latte';
    public string $layout       = '\\FooOrganization\\FooProject\\MainLayoutRoute';
}
```

```php
class PanelHomeRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\Panel\\Pages\\PithPanelPagesPack';
    public string $access_level = 'internal';
    public string $action       = '\\Pith\\Framework\\Panel\\Pages\\HomeAction';
    public string $view         = '[^route_folder]/home-view.phtml';
}
```

### Side-effect levels

`perform-user-login`, `perform-user-logout`, and `logout` do auth work inside `isAllowedToAccess()`, not in an Action. Login/logout levels often redirect and return `false`, so the rest of the workflow may not run meaningfully. Prefer them only on dedicated login/logout Routes.

## Denial behavior

When `checkAccess()` fails:

| Context | Result |
|---------|--------|
| Guest (HTTP) | 302 redirect to `PITH_APP_DEFAULT_LOGIN_PAGE_URL_PATH` (default `/login`) |
| Logged-in user (HTTP) | HTTP 403 with plain `Error 403` text (dedicated access-denied page is TODO) |
| Task process | Throws `PithException` code `4031` |

Load failures for an Access Level FQCN throw `4027` / `4028` (DI not found / dependency). Runtime errors inside an Access Level throw `4030`.

On HTTP requests, the first successful or failed access can also log an impression via `logImpressionOnFirstAccessOnly`.

## User / session access levels

Workflow Access Levels (Route gates) are related to—but distinct from—database and session user roles:

| Concept | Role |
|---------|------|
| Route `$access_level` | Gate: may this request run this Route? |
| `pith_access_levels` / `pith_user_access_levels` | Stored elevated roles for a user |
| `$_SESSION['access_levels']` | Snapshot of elevated role names at login |

At login, elevated levels are loaded into the session (levels above plain `user`). `webmaster` checks membership of `'webmaster'` in that array; `internal` currently treats webmaster as internal.

Assign elevated roles by linking `user_id` → `access_level_id` in `pith_user_access_levels` (for example `800` for `webmaster`). The session is snapshotted at login—users must re-login after role changes.

## IP and env config

IP-based levels read app constants (from env / tracked config):

```php
const PITH_APP_DEV_ACCESS_IP_ADDRESSES  = ['127.0.0.1'];
const PITH_APP_CRON_ACCESS_IP_ADDRESSES = ['127.0.0.1'];
```

`dev-ip` uses the first list; `cron-ip` and the HTTP branch of `task` use the second. Configure these in your env setup (see `config/setup-templates/env.setup.dist.txt`).

## Custom Access Levels

1. Extend `PithAccessLevel` and implement `isAllowedToAccess()`.
2. Keep the class PSR-4 autoloadable so PHP-DI can construct it (inject `PithAppRetriever` or other services in the constructor as needed).
3. Set the Route `$access_level` to the FQCN string.

```php
namespace FooOrganization\FooProject;

use Pith\Workflow\PithAccessLevel;
use Pith\Framework\PithAppRetriever;

class StaffOnlyAccessLevel extends PithAccessLevel
{
    private PithAppRetriever $app_retriever;

    public function __construct(PithAppRetriever $app_retriever)
    {
        $this->app_retriever = $app_retriever;
    }

    public function isAllowedToAccess(): bool
    {
        $app = $this->app_retriever->getApp();

        return $app->active_user->isLoggedIn()
            && in_array('staff', $_SESSION['access_levels'] ?? [], true);
    }
}
```

```php
class StaffDashboardRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\FooOrganization\\FooProject\\FooPack';
    public string $access_level = '\\FooOrganization\\FooProject\\StaffOnlyAccessLevel';
    // ...
}
```

To use a short name instead of an FQCN, add a branch in `PithAccessControl::getAccessLevel()`.

## Conventions

- Always set `$access_level` on every Route.
- Prefer built-in names (`'world'`, `'user'`, `'internal'`, `'task'`, …) unless you need custom logic.
- Secure the **Route**, not the Pack or Action.
- Remember page + layout: both Routes’ levels must allow.
- Treat side-effect levels (`perform-user-login`, etc.) as dedicated auth Routes only.
- Use double-backslash FQCNs in PHP strings (`'\\Foo\\Bar\\MyAccessLevel'`).
- Keep Access Level classes PSR-4 autoloadable so PHP-DI can load them.

## Related pieces

| Piece | Role |
|-------|------|
| [Routes](routes.md) (`PithRoute`) | Declares `$access_level`; the gate is enforced here |
| [Packs](packs.md) (`PithPack`) | May declare `$access_level`, but it is not checked at Pack load |
| [Actions](actions.md) (`PithAction`) | Run after access is allowed |
| `PithAccessControl` | Name → class map; `checkAccess()` / `isAllowedToAccess()` |
| `PithAccessLevel` | Base class for gate implementations |
| `PithDispatcher` | Calls `tapAccess` early and in the workflow |
| `PithActiveUser` / `PithSessionManager` | Login state, webmaster/internal checks, session levels |

## Important source files

- `vendor/pith/workflow-elements/src/base-workflow-elements/PithAccessLevel.php`
- `vendor/pith/workflow-elements/src/base-workflow-elements/PithRoute.php`
- `src/framework/external/framework-engine-components/PithAccessControl.php`
- `src/framework/external/framework-engine-components/PithDispatcher.php`
- `src/framework/external/framework-engine-components/PithActiveUser.php`
- `src/framework/external/framework-engine-components/PithSessionManager.php`
- `src/framework/internal/workflow-access-levels/`
- `config/setup-templates/env.setup.dist.txt`
- `migrations-postgres/Version20251119031801.php` (seeded `pith_access_levels` rows)
