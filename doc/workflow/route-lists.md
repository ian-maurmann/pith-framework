# Route Lists

Route Lists are how Pith declares URL routing. A Route List is a PHP class that extends `Pith\Workflow\PithRouteList` and defines a public `$routes` array. Each entry maps an HTTP method and path to a `PithRoute` class, or mounts another Route List under a path prefix.

Routing is backed by [FastRoute](https://github.com/nikic/FastRoute). Matching returns a route class FQCN; PHP-DI builds the `PithRoute`, and the dispatcher runs it.

## Base type

`PithRouteList` is intentionally small:

```php
class PithRouteList
{
    public array $routes = [];
}
```

## Route-List item format

Every entry is a 4-element array:

| Type | Format |
|------|--------|
| Leaf route | `['route', METHOD, path, '\\Namespace\\SomeRoute']` |
| Route group | `['route-group', '', path_prefix, '\\Namespace\\SomeRouteList']` |

- **route type** — Either `'route'` or `'route-group'`
- **METHOD** — For leaf routes, either a string (like `'GET'`) or array (like `['GET', 'POST']`) passed to FastRoute, for route groups this is unused, always `''` an empty string in practice.
- **path** — FastRoute path relative to the current group (`''` = group root). Supports placeholders such as `{filepath:.+}`.
- Handlers are always FQCNs of `PithRoute` (or nested `PithRouteList`) classes, not callables.

## Defining a Route List

```php
namespace FooOrganization\FooProject;

use Pith\Workflow\PithRouteList;

class FooRouteList extends PithRouteList
{
    public array $routes = [
        ['route', 'GET',           '/',           '\\FooOrganization\\FooProject\\HomeRoute'],
        ['route', 'GET',           '/about',      '\\FooOrganization\\FooProject\\AboutRoute'],
        ['route', 'GET',           '/contact-us', '\\FooOrganization\\FooProject\\ContactUsRoute'],
        ['route', ['GET', 'POST'], '/error-404',  '\\Pith\\Framework\\Plugin\\ErrorPages\\Error404Route'],
        ['route', ['GET', 'POST'], '/error-405',  '\\Pith\\Framework\\Plugin\\ErrorPages\\Error405Route'],
    ];
}
```

Use path constants for shared prefixes so route-spacing stays consistent across the app.

## Registering the app Route List

1. Point `PITH_APP_ROUTE_LIST` at the top-level list (see `tracked-constants.php`).
2. The front controller sets `$pith->config->route_list_namespace = PITH_APP_ROUTE_LIST`.
3. On `engine->start()`, `$config->load()` resolves that class via DI into `$config->route_list`.

## Composition

The top-level list usually mixes leaf routes and nested groups. Example pattern from `ExampleAppRouteList`:

```php
public array $routes = [
    ['route-group', '',              PITH_PANEL_PATH, '\\Pith\\Framework\\Panel\\PithPanelRouteList'],
    ['route',       ['GET', 'POST'], '/',             '\\Pith\\Framework\\SharedInfrastructure\\DefaultLandingRoute'],
    ['route',       ['GET', 'POST'], '/error-404',    '\\Pith\\Framework\\Plugin\\ErrorPages\\Error404Route'],
    ['route',       ['GET', 'POST'], '/error-405',    '\\Pith\\Framework\\Plugin\\ErrorPages\\Error405Route'],
    // ...
];
```

Groups can nest further. If `PITH_PANEL_PATH` is `/xxxxx/yyyyy/panel/`, a panel path like `PITH_PANEL_PATH` + `/users` becomes `/xxxxx/yyyyy/panel/users`.

## How matching works

1. `$engine->start()` loads config and asks `PithRouter` for the current route.
2. The router builds a FastRoute dispatcher from `$config->getRoutes()`.
3. `addRoutes()` walks the list:
   - `route` → `$r->addRoute(...)`
   - `route-group` → `$r->addGroup(...)`, load the nested list, recurse
4. Dispatch uses `REQUEST_METHOD` and the URI (query string stripped, rawurldecoded).
5. Outcomes:
   - **Found** — DI-load the `PithRoute`; path params become `route_parameters`
   - **Not found** — HTTP 404, rematch `/error-404`
   - **Method not allowed** — HTTP 405, rematch `/error-405`

Register `/error-404` and `/error-405` on the top-level list so those fallbacks resolve.

## What a matched Route looks like

A Route List entry points at a `PithRoute` subclass that configures the workflow item:

```php
class HomeRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\Panel\\Pages\\PithPanelPagesPack';
    public string $access_level = 'internal';
    public string $action       = '\\Pith\\Framework\\Panel\\Pages\\HomeAction';
    public string $view         = '[^route_folder]/home-view.latte';
    public string $layout       = '\\Pith\\Framework\\Panel\\Theme\\MainLayoutRoute';
}
```

## Conventions

- Name classes `*RouteList` / `*AppRouteList`, and targets `*Route`.
- Prefer path constants for prefixes.
- Use `''` for a group’s index page.
- Use double-backslash FQCNs in PHP strings (`'\\Pith\\...'`).
- Keep handlers PSR-4 autoloadable; listing them in `$routes` is enough—no separate registrar.

## Related pieces

| Piece | Role |
|-------|------|
| `PithRouteList` | Declares `$routes` |
| `PithRoute` | Matched workflow config |
| `PithConfig` | Holds and loads the app route list |
| `PithRouter` | Expands lists into FastRoute and matches |
| `PithEngine` / `PithDispatcher` | Start request and run the matched route |
| `PITH_APP_ROUTE_LIST` | Top-level list FQCN |
| `PITH_APP_TASKS_ROUTE_LIST` | Separate list used by the panel tasks UI |

## Important source files

- `vendor/pith/workflow-elements/src/base-workflow-elements/PithRouteList.php`
- `src/framework/external/framework-engine-components/PithRouter.php`
- `src/framework/external/framework-engine-components/PithConfig.php`
- `src/plugins/routing-example/src/ExampleAppRouteList.php`
- `config/setup-templates/app-route-list.setup.dist.txt`
- `tracked-constants.php`, `front-controller.php`
