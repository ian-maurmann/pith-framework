# Routes

A Route is a workflow configuration class. It extends `Pith\Workflow\PithRoute` and declares how a request is handled: type, pack, access, action, preparer, view, layout, and related options.

[Route Lists](route-lists.md) map an HTTP method and path to a Route class FQCN. PHP-DI builds the `PithRoute`, and `PithDispatcher` runs it. The Route itself is not a callable controller—it wires the pieces the dispatcher executes.

## Base type

`PithRoute` holds public config properties and loaders (`getAction`, `getPack`, `getPreparer`, and so on). Defaults cover the optional pieces:

| Property | Role                                             | Default |
|----------|--------------------------------------------------|--------|
| `$route_type` | How the dispatcher handles the Route             | required |
| `$pack` | Pack FQCN (feature folder)                       | required |
| `$access_level` | Named access level or access-level FQCN          | required |
| `$action` | Action FQCN                                      | `EmptyAction` |
| `$preparer` | Preparer FQCN                                    | `PassThroughPreparer` |
| `$view` | View path expression                             | `''` |
| `$view_adapter` | View adapter FQCN                                | Latte adapter |
| `$view_requisition` | View requisition FQCN                            | `EmptyViewRequisition` |
| `$layout` | Layout Route FQCN                                | `''` (none) |
| `$resource_folder` | Folder for `resource-folder` routes              | `''` |
| `$resource_path` | File for `resource-file` routes                  | `''` |
| `$cache_level` | Named cache level or full `Cache-Control:` header | `''` |
| `$page_title` | Page title for `<title>`                         | `''` |
| `$meta_keywords` | Keywords for `<meta name="keywords">`            | `''` |
| `$meta_description` | Description for `<meta name="description">`      | `''` |
| `$meta_robots` | Value for `<meta name="robots">`                 | `'index, follow'` |

## Route types

`$route_type` selects the dispatch branch:

| Type | Behavior |
|------|----------|
| `page` / `error-page` | If `$layout` is set, run that layout with this Route as page content; otherwise run the workflow directly |
| `layout` | Full workflow; view is the layout shell |
| `partial` | Full workflow, no layout wrap; often inserted from a layout or page view |
| `endpoint` | Full workflow, typically with a JSON view adapter |
| `task` / `job` | Full workflow; tasks are often run via `runTaskRoute()` as well as HTTP |
| `resource-folder` | Serve a file under `$resource_folder` (path from `route_parameters['filepath']`) |
| `resource-file` | Serve the single file at `$resource_path` |

Documented values on `PithRoute` are: `'layout'`, `'page'`, `'partial'`, `'error-page'`, `'endpoint'`, `'resource-file'`, `'resource-folder'`. The dispatcher also handles `'task'`, `'job'`, and the alias `'partial-route'`.

Static resource routes skip Action → Preparer → View.

## Defining a Route

Extend `PithRoute` and set the properties the request needs:

```php
namespace FooOrganization\FooProject;

use Pith\Workflow\PithRoute;

class HomeRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\FooOrganization\\FooProject\\FooPack';
    public string $access_level = 'world';
    public string $action       = '\\FooOrganization\\FooProject\\HomeAction';
    public string $view         = '[^route_folder]/home-view.latte';
    public string $layout       = '\\FooOrganization\\FooProject\\MainLayoutRoute';

    public string $page_title       = 'Home - ' . PITH_APP_MAIN_TITLE;
    public string $meta_keywords    = 'home, ' . PITH_APP_META_KEYWORDS;
    public string $meta_description = 'Home. ' . PITH_APP_META_DESCRIPTION;
    public string $meta_robots      = 'index, follow';
}
```

List the Route FQCN in a [Route List](route-lists.md). That is registration—there is no separate Route registrar. Keep the class PSR-4 autoloadable so PHP-DI can load it.

## Workflow pieces

A normal (non-resource) Route runs this pipeline:

1. **Route** — inject DI; resolve route folder
2. **Pack** — load Pack; resolve pack folder
3. **Access** — `access_control->checkAccess`
4. **Action** — application logic fills `$prepare` (see [Actions](actions.md))
5. **Preparer** — shapes `$prepare` into `$view` variables
6. **View Requisition** — headers and front-end resources
7. **Responder** — register resources (partials may insert immediately)
8. **View** — resolve the view path expression; [View Adapter](view-adapters.md) renders

Omit `$action` / `$preparer` / `$view_requisition` to get the graceful fallbacks (`EmptyAction`, `PassThroughPreparer`, `EmptyViewRequisition`).

## Layouts and partials

**Pages with a layout:** if `$route_type` is `page` or `error-page` and `$layout` is set, the dispatcher loads the layout Route, applies page metadata, and dispatches the layout with the page as the secondary Route. The layout view inserts page content (for example via `insertPageContent` / `insertPageContentByRoute`).

**Partials:** a `partial` Route runs the same Action → Preparer → View path without a layout wrap. Insert one from a Latte view with `{insertPartial('...PartialRoute')}`, or run it programmatically with `$engine->runPartial(...)`.

```php
class AccountBarPartialRoute extends PithRoute
{
    public string $route_type   = 'partial';
    public string $pack         = '\\Pith\\Framework\\Panel\\Pages\\PithPanelPagesPack';
    public string $access_level = 'internal';
    public string $action       = '\\Pith\\Framework\\Panel\\Pages\\AccountBarAction';
    public string $view         = '[^route_folder]/account-bar-partial-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
```

```php
class MainLayoutRoute extends PithRoute
{
    public string $route_type       = 'layout';
    public string $pack             = '\\FooOrganization\\FooProject\\FooPack';
    public string $access_level     = 'world';
    public string $view_requisition = '\\FooOrganization\\FooProject\\MainLayoutViewRequisition';
    public string $view             = '[^route_folder]/main-layout-view.latte';
}
```

## Endpoints

Endpoints use the same workflow as partials, usually with a JSON view adapter and no layout:

```php
class CreateNewUserRoute extends PithRoute
{
    public string $route_type   = 'endpoint';
    public string $pack         = '\\Pith\\Framework\\Plugin\\UserSystem5\\PithUserSystem5Pack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\Plugin\\UserSystem5\\CreateNewUserAction';
    public string $view_adapter = '\\Pith\\JsonEndpointViewAdapter\\PithJsonEndpointViewAdapter';
}
```

## Resource Routes

**Resource folder** — serve files under `$resource_folder`. Pair with a FastRoute path that captures a greedy filepath (for example `{filepath:.+}`). The matched `filepath` is available on the request as `route_parameters['filepath']`.

```php
class AppResourceRoute extends PithRoute
{
    public string $route_type      = 'resource-folder';
    public string $pack            = '\\FooOrganization\\FooProject\\FooPack';
    public string $access_level    = 'world';
    public string $resource_folder = '[^route_folder]/resource/';
    public string $cache_level     = 'Cache-Control: public, max-age=31536000, immutable, stale-while-revalidate=604800, stale-if-error=1209600';
}
```

**Resource file** — serve one file from `$resource_path`.

`$cache_level` may be a named alias or a full `Cache-Control:` header string. The dispatcher applies it when serving resources.

## Path expressions

View and resource paths are expressions, not raw absolute paths:

- `[^route_folder]` — directory of the Route class file
- `[^pack_folder]` — directory of the Pack class file

Example: `'[^route_folder]/home-view.latte'` resolves next to the Route PHP file.

## Access control

`$access_level` is a named level (such as `'world'`, `'user'`, `'internal'`, `'task'`) or an access-level FQCN. Access is checked early in `dispatch` and again in the normal workflow taps. Denied access redirects or returns 403—there is no separate middleware stack.

## How a request runs

1. `$engine->start()` loads config and asks `PithRouter` for the current Route (see [Route Lists](route-lists.md)).
2. On match, PHP-DI builds the `PithRoute`; FastRoute path params become `route_parameters`.
3. `PithDispatcher::dispatch($route)` branches on `$route_type`.
4. Non-resource Routes run `dispatchRoute` (Pack → Access → Action → Preparer → View Requisition → Responder → View).

Routes can also run without a URL rematch:

| API | Use |
|-----|-----|
| `$engine->runPartial($fqcn)` | Nested partial |
| `$engine->runLayout($fqcn)` | Layout alone |
| `$engine->runRoute($fqcn)` | Any Route by FQCN |
| `$engine->runTaskRoute($fqcn)` | Task Route (same as `runRoute`) |

## Conventions

- Name classes `*Route` (pages), `*PartialRoute`, `*LayoutRoute`, `*ResourceRoute`, `*TaskRoute` as fits the type.
- Always set `$route_type`, `$pack`, and `$access_level`.
- Prefer `[^route_folder]` for views and resources that live beside the Route.
- Use double-backslash FQCNs in PHP strings (`'\\Pith\\...'`).
- Keep Routes PSR-4 autoloadable; listing them in a Route List is enough.

## Related pieces

| Piece | Role |
|-------|------|
| `PithRoute` | Workflow config for a matched (or programmatically run) request |
| [Route Lists](route-lists.md) (`PithRouteList`) | Maps URLs to Route FQCNs |
| [Actions](actions.md) (`PithAction`) | Application logic; runs after access, before Preparer |
| [Packs](packs.md) (`PithPack`) | Feature pack; supplies pack folder |
| `PithPreparer` | Shapes `$prepare` → `$view` |
| [View Adapters](view-adapters.md) | Render backends selected by `$view_adapter` |
| `PithViewRequisition` | Headers and front-end resources |
| `PithRouter` | Matches URL → Route |
| `PithEngine` / `PithDispatcher` | Start request and run the Route pipeline |

## Important source files

- `vendor/pith/workflow-elements/src/base-workflow-elements/PithRoute.php`
- `src/framework/external/framework-engine-components/PithDispatcher.php`
- `src/framework/external/framework-engine-components/PithEngine.php`
- `src/framework/external/framework-engine-components/PithRouter.php`
- `src/plugins/panel-2/packs/panel-pages-pack/home/HomeRoute.php`
- `src/plugins/panel-2/packs/panel-theme-pack/main-layout/MainLayoutRoute.php`
- `config/setup-templates/for-pack/for-page-2/Page2Route.setup.dist.txt`
- `config/setup-templates/for-pack/for-layout/MainLayoutRoute.setup.dist.txt`
- `config/setup-templates/for-pack/for-resources/AppResourceRoute.setup.dist.txt`
