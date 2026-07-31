# View Requisitions

A View Requisition declares the HTTP headers and front-end resources a Route needs—scripts, stylesheets, and preloads. It extends `Pith\Workflow\PithViewRequisition`. The dispatcher runs it after the Preparer and before the Responder and [View Adapter](view-adapters.md).

Application data stays in the [Action](actions.md) / Preparer. The View Requisition’s job is what goes in `<head>` (and related tags): charset headers, CSS, JS, and preload hints.

## Base type

`PithViewRequisition` holds two lists and helper methods to fill them:

```php
class PithViewRequisition extends PithWorkflowElement
{
    public    string $element_type     = 'view-requisition';
    public    string $requisition_type = 'view-requisition';
    protected array  $headers          = [];
    protected array  $resources        = [];

    public function provisionViewRequisition()
    {
        $this->headers   = [];
        $this->resources = [];
    }

    public function runRequisition()
    {
        // Do nothing.
    }
}
```

`provisionViewRequisition()` clears both lists. Override `runRequisition()` to call `addHeader`, `addScript`, `addStylesheet`, `addPreload`, or their CDN variants. `getHeaders()` / `getResources()` return what you added.

`$requisition_type` is a conventional marker. Layouts often use `'layout-view-requisition'`; pages and partials usually keep `'view-requisition'`. The engine does not branch on it.

## Defining a View Requisition

Extend `PithViewRequisition` and add headers and resources in `runRequisition()`:

```php
namespace FooOrganization\FooProject;

use Pith\Workflow\PithViewRequisition;

class MainLayoutViewRequisition extends PithViewRequisition
{
    public string $requisition_type = 'layout-view-requisition';

    public function runRequisition()
    {
        $this->addHeader('Use UTF-8 Encoding', 'Content-Type: text/html; charset=utf-8');

        $this->addStylesheet('Fixie Reset', '/resources/vendor/.../fixie-reset.css', 'reset');
        $this->addScript('jQuery', '/resources/vendor/.../jquery-3.6.4.min.js', 'library-for-layout');
        $this->addStylesheet('App layout CSS', '/resources/app/main-layout.css', 'application-for-layout');
    }
}
```

Page-specific assets use page roles:

```php
class TasksViewRequisition extends PithViewRequisition
{
    public string $requisition_type = 'view-requisition';

    public function runRequisition()
    {
        $this->addStylesheet('Task Control CSS', PITH_PANEL_PATH . '/resources/feature/task-control/panel-task-control.css', 'application-for-page');
        $this->addScript('Task Control JS', PITH_PANEL_PATH . '/resources/feature/task-control/panel-task-control.js', 'application-for-page');
    }
}
```

PHP-DI builds the class from its FQCN. Listing it on the Route is enough—there is no separate View Requisition registry. Keep the class PSR-4 autoloadable.

## Wiring from a Route

Point the Route’s `$view_requisition` at the class:

```php
class MainLayoutRoute extends PithRoute
{
    public string $route_type       = 'layout';
    public string $pack             = '\\Pith\\Framework\\Panel\\Theme\\PithPanelThemePack';
    public string $access_level     = 'world';
    public string $view_requisition = '\\Pith\\Framework\\Panel\\Theme\\MainLayoutViewRequisition';
    public string $view             = '[^route_folder]/main-layout-view.latte';
}
```

```php
class TasksRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\Panel\\Pages\\PithPanelPagesPack';
    public string $access_level     = 'webmaster';
    public string $action           = '\\Pith\\Framework\\Panel\\Pages\\TasksAction';
    public string $view_requisition = '\\Pith\\Framework\\Panel\\Pages\\TasksViewRequisition';
    public string $view             = '[^route_folder]/tasks-view.latte';
    public string $layout           = '\\Pith\\Framework\\Panel\\Theme\\MainLayoutRoute';
}
```

If `$view_requisition` is omitted, the Route defaults to `\\Pith\\Workflow\\GracefulFallback\\EmptyViewRequisition`, a no-op. An empty string throws PithException **4024**. PHP-DI failures raise **4025** / **4026**.

## How it runs

After Action and Preparer:

1. `PithDispatcher` calls `tapViewRequisition($route, $secondary_route)`.
2. `$route->getViewRequisition()` resolves `$view_requisition` via PHP-DI.
3. `dispatchViewRequisition()` calls `provisionViewRequisition()`, then `runRequisition()`.
4. Headers from `getHeaders()` are sent with `header(...)` when headers are not already sent.
5. Resources from `getResources()` are returned to the dispatcher.
6. `tapResponder` registers those resources on `PithResponder`.
7. The [View Adapter](view-adapters.md) renders; layouts (and pages without a layout wrap) emit tags via `{insertResourceFiles(...)}` / `insertResourceFiles(...)`.

For a layout with a content page, the dispatcher runs **both** requisitions: layout first, then the page (`$secondary_route`). Their resource arrays are merged so the layout head can include page CSS/JS as well.

Headers are skipped once headers are already sent—so nested partials do not re-send layout/page headers.

View Requisitions run for `page`, `error-page`, `layout`, `partial`, `endpoint`, `task`, and `job` routes. Static `resource-folder` / `resource-file` routes skip this path.

## Headers

`addHeader($name, $http_header, $replace = true, $response_code = 0)` queues an HTTP header. The human-readable `$name` is for documentation in the array; only `$http_header` (plus replace / response code) is passed to PHP’s `header()`.

Typical use on layouts:

```php
$this->addHeader('Use UTF-8 Encoding', 'Content-Type: text/html; charset=utf-8');
```

## Resources

Each resource is an array with at least `name`, `resource_type`, `filepath`, and `role`. Resource types:

| Type | Helper | Emits |
|------|--------|--------|
| `script` | `addScript` / `addCdnScript` | `<script src="...">` |
| `stylesheet` | `addStylesheet` / `addCdnStylesheet` | `<link rel="stylesheet" href="...">` |
| `preload` | `addPreload` / `addCdnPreload` | `<link rel="preload" ...>` |

`$filepath` is usually a public URL path (for example `/resources/vendor/...`). CDN helpers also take integrity, crossorigin, and a local fallback path.

### Roles and insert order

Roles control when `PithResponder::insertResourceFiles()` writes the tags. Insertion order:

| Order | Role | Typical use |
|-------|------|-------------|
| 1 | `src-fallback` | SRI / mutation-observer fallback scripts |
| 2 | `font-preload` | Font CSS preloads |
| 3 | `reset` | CSS resets |
| 4 | `preload` | Other preloads |
| 5 | `library-for-layout` | Shared library CSS/JS on the layout |
| 6 | `library-for-page` | Library assets for a page |
| 7 | `library-for-partial` | Library assets for a partial |
| 8 | `application-for-layout` | App CSS/JS for the layout shell |
| 9 | `application-for-page` | App CSS/JS for the page |
| 10 | `application-for-partial` | App CSS/JS for a partial |
| 11 | `font-stylesheet` | Font stylesheets (after other CSS) |

Default role for `addScript` / `addStylesheet` is `'application-for-page'`. Default for `addPreload` is `'preload'`. Pick layout vs page vs partial roles so ordering stays predictable when layout and page resources merge.

The responder deduplicates by filepath: the same path is inserted only once per response.

### CDN resources

```php
$this->addCdnScript(
    'jQuery',
    'https://code.jquery.com/jquery-3.7.1.min.js',
    'sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=',
    'anonymous',
    '/resources/vendor/common-libraries/jquery/jquery-3.6.4/jquery-3.6.4.min.js',
    'library-for-page'
);
```

CDN tags include `integrity`, `crossorigin`, and `x-sri-fallback` pointing at the local path. Pair with `src-fallback` scripts when you rely on SRI fallback behavior.

## Emitting resources in the view

Resources are registered on the Responder after the View Requisition runs. They are not auto-printed for layouts and pages—the layout (or page) view must call the insert helper:

```latte
{insertResourceFiles(2)}
```

```php
<?php $this->insertResourceFiles(2); ?>
```

The optional indent argument is spaces × 4 for readable HTML.

**Partials:** when `$route_type` is `partial` (or `partial-route`), `tapResponder` calls `insertResourceFiles()` immediately after registering resources, so partial-owned assets can appear at the insertion point without waiting for the layout head.

## Layouts and pages together

A page with `$layout` set does not run its own view as the outer document. The dispatcher runs the **layout** Route and passes the page as `$secondary_route`. Both View Requisitions run; resources merge (layout, then page). The layout view’s `{insertResourceFiles(...)}` therefore outputs shared theme assets and page-specific CSS/JS in role order.

Put shared libraries and shell assets on the layout requisition (`*-for-layout`). Put page-only assets on the page requisition (`*-for-page`).

## Conventions

- Name classes `*ViewRequisition`.
- Override `runRequisition()`; leave `provisionViewRequisition()` alone unless you have a specific reason.
- Use `'layout-view-requisition'` on layout requisitions; `'view-requisition'` elsewhere.
- Choose roles deliberately so insert order stays correct when layout and page merge.
- Prefer local `/resources/...` paths; use CDN helpers when you need SRI + fallback.
- Use double-backslash FQCNs in PHP strings (`'\\Pith\\...'`).
- Keep View Requisitions PSR-4 autoloadable; wiring them on the Route is registration.
- Omit `$view_requisition` when you need no headers or front-end files (`EmptyViewRequisition`).

## Related pieces

| Piece | Role |
|-------|------|
| `PithViewRequisition` | Base class for headers and front-end resources |
| [Routes](routes.md) (`PithRoute`) | Declares `$view_requisition`; loads via `getViewRequisition()` |
| [Actions](actions.md) (`PithAction`) | Application logic (not asset lists) |
| [View Adapters](view-adapters.md) | Render; expose `insertResourceFiles` helpers |
| `PithResponder` | Stores resources; emits tags by role |
| `EmptyViewRequisition` | Default no-op View Requisition |
| `PithDispatcher` | Runs `tapViewRequisition` → `tapResponder` → `tapView` |

## Important source files

- `vendor/pith/workflow-elements/src/base-workflow-elements/PithViewRequisition.php`
- `vendor/pith/workflow-elements/src/fallback-workflow-elements/EmptyViewRequisition.php`
- `vendor/pith/workflow-elements/src/base-workflow-elements/PithRoute.php`
- `src/framework/external/framework-engine-components/PithDispatcher.php`
- `src/framework/external/framework-engine-components/PithResponder.php`
- `src/plugins/panel-2/packs/panel-theme-pack/main-layout/MainLayoutViewRequisition.php`
- `src/plugins/panel-2/packs/panel-theme-pack/main-layout/MainLayoutRoute.php`
- `src/plugins/panel-2/packs/panel-pages-pack/tasks/TasksViewRequisition.php`
- `src/plugins/panel-2/packs/panel-pages-pack/tasks/TasksRoute.php`
- `config/setup-templates/for-pack/for-layout/MainLayoutViewRequisition.setup.dist.txt`
- `config/setup-templates/for-pack/for-login/LoginViewRequisition.setup.dist.txt`
