# Views

A View is the render end of a Route’s workflow: a template path (`$view`), variables shaped by Action → Preparer, a [View Adapter](view-adapters.md) that produces the response, and often a [View Requisition](view-requisitions.md) for headers and front-end assets.

There is no `PithView` class or separate View registry. The [Route](routes.md) declares `$view` (and usually `$view_adapter` / `$view_requisition`). PHP-DI builds the adapter and requisition; `PithDispatcher` resolves the path and runs the adapter.

## Where they fit

A normal (non-resource) Route runs:

**Action → Preparer → View Requisition → Responder → View Adapter**

| Piece | Role |
|-------|------|
| `$view` | Path expression to a template (`.latte` / `.phtml`), or unused for JSON/CLI |
| `$view_adapter` | Duck-typed render backend (Latte by default) |
| `$view_requisition` | HTTP headers and CSS/JS/preloads |
| Preparer `$view` object | Variables passed into the template |
| Template file | Markup that uses those variables and insert helpers |

Static `resource-folder` / `resource-file` Routes skip Action → Preparer → View entirely.

## Wiring from a Route

Set `$view` to a path expression next to the Route (or under the Pack). Latte is the default adapter, so HTML pages and layouts often omit `$view_adapter`:

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

```php
class MainLayoutRoute extends PithRoute
{
    public string $route_type       = 'layout';
    public string $pack             = '\\Pith\\Framework\\Panel\\Theme\\PithPanelThemePack';
    public string $access_level     = 'world';
    public string $action           = '\\Pith\\Framework\\Panel\\Theme\\MainLayoutAction';
    public string $view_requisition = '\\Pith\\Framework\\Panel\\Theme\\MainLayoutViewRequisition';
    public string $view             = '[^route_folder]/main-layout-view.latte';
}
```

Override `$view_adapter` for `.phtml` templates, JSON endpoints, and CLI tasks. See [View Adapters](view-adapters.md).

## Path expressions

`$view` is an expression, not a raw absolute path. `PithExpressionUtility::getViewPathFromExpression` substitutes:

- `[^route_folder]` — directory of the Route class file
- `[^pack_folder]` — directory of the Pack class file

Example: `'[^route_folder]/tasks-view.latte'` resolves to a file beside `TasksRoute.php`. Prefer `[^route_folder]` when the template lives with the Route.

## Data into the template

The [Action](actions.md) pushes values onto `$this->prepare`. The Preparer shapes those into `$view` variables for the adapter.

With the default `PassThroughPreparer`, prepare properties become view variables as-is:

```php
// In the Action
$this->prepare->PITH_PANEL_PATH = PITH_PANEL_PATH;
$this->prepare->task_routes     = $task_routes;
```

```latte
{foreach $task_routes as $task_route_index => $task_route}
    <tr data-task="{$task_route[2]}">
        <td>{$task_route[2]}</td>
    </tr>
{/foreach}
```

Use a custom Preparer when you need to cast, escape, or reshape data before render. Keep business logic in the Action; keep escaping and presentation shaping in the Preparer.

Latte templates receive variables as `$name`. PHTML adapters `extract()` the view object into local scope and expose insert helpers as methods on `$this`.

## How it runs

After Action, Preparer, View Requisition, and Responder:

1. `PithDispatcher::tapView` reads `$route->view`.
2. The path expression is resolved with pack and route folders.
3. `$route->getViewAdapter()` loads the adapter via PHP-DI.
4. The dispatcher calls `setApp`, `setFilePath`, `setResources`, and `setVars`.
5. For a layout with a content page, it also calls `setIsLayout(true)` and `setContentRoute($page_route)`.
6. `run()` renders or emits the response.

Views run for `page`, `error-page`, `layout`, `partial`, `endpoint`, `task`, and `job` Routes. Partials invoked via `$engine->runPartial(...)` still run Action → Preparer → View.

## Layouts and partials

**Pages with a layout:** if `$route_type` is `page` or `error-page` and `$layout` is set, the dispatcher runs the **layout** Route and passes the page as `$secondary_route`. The layout Action → Preparer → View run first. The page Action and page view run later, when the layout template inserts page content—for example `{insertPage()}` in Latte.

A typical layout shell:

```latte
<title>{insertPageTitle()}</title>
{insertMetaRobots(2)}
{insertResourceFiles(2)}
...
{insertPartial('Pith\\Framework\\Panel\\Pages\\AccountBarPartialRoute')}
...
{insertPage()}
```

Common insert helpers (Latte macros / PHTML methods):

| Helper | Role |
|--------|------|
| `insertPageTitle` | Page `$page_title` into `<title>` |
| `insertMetaDescription` / `insertMetaKeywords` / `insertMetaRobots` | Page meta from the Route |
| `insertResourceFiles` | Emit queued CSS/JS/preloads by role |
| `insertPartial('...PartialRoute')` | Run a nested partial Route |
| `insertPage` / `insertPageContent` | Run the content page inside a layout |

Resources from the [View Requisition](view-requisitions.md) are registered on `PithResponder`; layouts and pages must call `insertResourceFiles` to print tags. Partials may insert their resources immediately when dispatched.

**Partials:** a `partial` Route runs the same Action → Preparer → View path without a layout wrap. Insert one from a view with `{insertPartial('...PartialRoute')}`, or run it with `$engine->runPartial(...)`.

## Non-template Views

JSON endpoints and CLI tasks still go through a View Adapter, but they ignore `$view`:

- **JSON** — Action sets `$this->prepare->response`; the JSON adapter encodes it.
- **CLI** — output comes from `$app->cli_writer`, not a template file.

Details and examples are in [View Adapters](view-adapters.md).

## Conventions

- Name templates `*-view.latte` (or `*-view.phtml`) and keep them beside the Route.
- Prefer Latte for new HTML Routes; omit `$view_adapter` when the default is correct.
- Always set `$view_adapter` for `.phtml`, JSON, and CLI Routes.
- Use path expressions (`[^route_folder]`, `[^pack_folder]`) for `$view`.
- Push data from the Action via `$this->prepare->…`; use a custom Preparer only when you need to shape or escape for the template.
- Use double-backslash FQCNs in PHP strings (`'\\Pith\\...'`).
- Do not expect a View on `resource-folder` / `resource-file` Routes.

## Related pieces

| Piece | Role |
|-------|------|
| [Routes](routes.md) (`PithRoute`) | Declares `$view`, `$view_adapter`, `$view_requisition`, `$layout` |
| [Actions](actions.md) (`PithAction`) | Fills `$prepare` for the Preparer / view |
| `PithPreparer` / `PassThroughPreparer` | Shapes `$prepare` → `$view` variables |
| [View Adapters](view-adapters.md) | Render backends selected by `$view_adapter` |
| [View Requisitions](view-requisitions.md) | Headers and front-end resources |
| `PithResponder` | Stores resources; emits tags via insert helpers |
| `PithExpressionUtility` | Resolves `[^route_folder]` / `[^pack_folder]` |
| `PithDispatcher::tapView` | Provisions the adapter and calls `run()` |

## Important source files

- `vendor/pith/workflow-elements/src/base-workflow-elements/PithRoute.php`
- `vendor/pith/workflow-elements/src/fallback-workflow-elements/PassThroughPreparer.php`
- `src/framework/external/framework-engine-components/PithDispatcher.php`
- `src/framework/external/framework-engine-components/PithResponder.php`
- `src/framework/internal/utilities/PithExpressionUtility.php`
- `src/plugins/panel-2/packs/panel-pages-pack/tasks/TasksRoute.php`
- `src/plugins/panel-2/packs/panel-pages-pack/tasks/TasksAction.php`
- `src/plugins/panel-2/packs/panel-pages-pack/tasks/tasks-view.latte`
- `src/plugins/panel-2/packs/panel-theme-pack/main-layout/MainLayoutRoute.php`
- `src/plugins/panel-2/packs/panel-theme-pack/main-layout/main-layout-view.latte`
- `config/setup-templates/for-pack/for-page-2/Page2Route.setup.dist.txt`
- `config/setup-templates/for-pack/for-layout/MainLayoutRoute.setup.dist.txt`
