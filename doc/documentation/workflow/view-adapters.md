# View Adapters

A View Adapter is the final render backend in a Route’s workflow. It turns Preparer output into the HTTP or CLI response—HTML via Latte or PHTML, JSON for endpoints, or plain-text task output.

There is no formal interface or trait. Adapters are duck-typed: they share the method convention that `PithDispatcher::tapView` calls. Set `$view_adapter` on a [Route](routes.md) to an adapter FQCN; PHP-DI builds the class and the dispatcher provisions it, then calls `run()`.

## Where they fit

A normal (non-resource) Route runs Action → Preparer → View Requisition → Responder → **View Adapter**. Resource routes (`resource-folder` / `resource-file`) skip adapters entirely.

In `tapView`, the dispatcher:

1. Resolves `$view` with `[^route_folder]` / `[^pack_folder]` path expressions
2. Loads the adapter via `$route->getViewAdapter()`
3. Calls `setApp`, `setFilePath`, `setResources`, `setVars`
4. For layouts with a content page, calls `setIsLayout(true)` and `setContentRoute(...)`
5. Calls `run()`

## Wiring from a Route

`$view` is a path expression (when the adapter needs a template). `$view_adapter` is the adapter FQCN. On `PithRoute`, Latte is the default:

```php
public string $view_adapter = '\\Pith\\LatteViewAdapter\\PithLatteViewAdapter';
```

Override `$view_adapter` for `.phtml` views, JSON endpoints, and CLI tasks. An empty `$view_adapter` throws PithException **4014**. PHP-DI failures raise **4015** / **4016**.

Listing the FQCN on the Route is enough—there is no separate adapter registry. Keep the class PSR-4 autoloadable so PHP-DI can load it.

## Built-in adapters

| Adapter | FQCN | Typical `$route_type` | Needs `$view`? |
|---------|------|----------------------|----------------|
| Latte | `\\Pith\\LatteViewAdapter\\PithLatteViewAdapter` | `page` / `layout` / `partial` | yes (`.latte`) |
| PHTML | `\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2` | `partial` / older pages | yes (`.phtml`) |
| JSON | `\\Pith\\JsonEndpointViewAdapter\\PithJsonEndpointViewAdapter` | `endpoint` | no |
| CLI | `\\Pith\\CliViewAdapter\\PithCliViewAdapter` | `task` / `job` | no |

### Latte (default)

`PithLatteViewAdapter` clones `PithLatteViewRunner` and renders with `Latte\Engine`. Compiled templates cache under `PITH_LATTE_CACHE_PATH`.

Latte views can call helpers registered by the runner, including `{insertPageTitle()}`, `{insertMetaDescription()}`, `{insertMetaKeywords()}`, `{insertMetaRobots()}`, `{insertResourceFiles(...)}`, `{insertPartial('...PartialRoute')}`, `{insertPage()}`, and `{insertPageContentByRoute(...)}`.

Because Latte is the Route default, Latte pages and layouts often omit `$view_adapter`:

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

### PHTML

`PithPhtmlViewAdapter2` clones `PithPhtmlViewRunner2`, `require`s the `.phtml` file, and `extract()`s view variables into scope. The runner exposes the same insert helpers as PHP methods (`insertPageTitle()`, `insertPartial(...)`, `insertPageContent(...)`, and so on).

`.phtml` Routes must set `$view_adapter` explicitly—the default Latte adapter will not render PHTML:

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

### JSON

`PithJsonEndpointViewAdapter` ignores `$view`. It sets `Content-Type: application/json`, reads `$variables->response`, and echoes `json_encode(..., JSON_FORCE_OBJECT | JSON_PRETTY_PRINT)`. If `response` is missing, it returns HTTP 500 with `{"status":"error","data":{"problem":"no response set"}}`.

Typical pattern: the [Action](actions.md) sets `$this->prepare->response`; the default `PassThroughPreparer` copies it to the view variables.

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

### CLI

`PithCliViewAdapter` ignores `$view`. It reads writes from `$app->cli_writer`, joins them with `\r\n`, and optionally echoes them as `text/plain` when `should_echo_cli_output` is set. When `PITH_COMMAND_TASK_OUTPUT_LOG_ENABLE` is on, it also logs via `PithTaskLogger`.

```php
class HelloWorldTaskRoute extends PithRoute
{
    public string $route_type   = 'task';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\HelloWorldTaskAction';
    public string $view_adapter = '\\Pith\\CliViewAdapter\\PithCliViewAdapter';
}
```

## Layouts

For `page` / `error-page` Routes with `$layout` set, the dispatcher runs the **layout** Route and passes the page as `$secondary_route`. The layout adapter receives `setIsLayout(true)` and `setContentRoute($page_route)`. The layout view inserts page content—for example `{insertPage()}` in Latte or `insertPageContent(...)` in PHTML.

## Shared method convention

Custom adapters need the same public surface that `tapView` calls:

| Method | Role |
|--------|------|
| `setApp(PithApp $app)` | App handle |
| `setFilePath(string $path)` | Resolved view path (may be unused) |
| `setResources(array $resources)` | Stored; resources are usually emitted via Responder / insert helpers |
| `setVars($view_variables)` | Object of view variables from the Preparer |
| `setIsLayout(bool)` / `setContentRoute($route)` | Layout mode and nested page Route |
| `run()` | Render or emit the response |
| `reset()` | Clear state (typically from the constructor) |

Latte and PHTML adapters clone their runners inside `run()` so shared DI instances stay safe across renders.

## Conventions

- Prefer Latte for new HTML Routes; omit `$view_adapter` when the default is correct.
- Always set `$view_adapter` for `.phtml`, JSON, and CLI Routes.
- Use path expressions (`[^route_folder]`, `[^pack_folder]`) for template `$view` values.
- Use double-backslash FQCNs in PHP strings (`'\\Pith\\...'`).
- Keep adapters PSR-4 autoloadable under `src/view-adapters/`; wiring them on the Route is registration.
- Do not expect a View Adapter on `resource-folder` / `resource-file` Routes.

## Related pieces

| Piece | Role |
|-------|------|
| [Routes](routes.md) (`PithRoute`) | Declares `$view` and `$view_adapter`; loads the adapter |
| [Actions](actions.md) (`PithAction`) | Fills `$prepare` (for example `response` for JSON) |
| [Packs](packs.md) (`PithPack`) | Supplies pack folder for path expressions |
| `PithPreparer` | Shapes `$prepare` → `$view` variables |
| `PithDispatcher::tapView` | Provisions the adapter and calls `run()` |
| `PithRoute::getViewAdapter` | Resolves `$view_adapter` via PHP-DI |

## Important source files

- `src/view-adapters/latte-view-adapter/src/PithLatteViewAdapter.php`
- `src/view-adapters/latte-view-adapter/src/PithLatteViewRunner.php`
- `src/view-adapters/phtml-view-adapter-2/src/PithPhtmlViewAdapter2.php`
- `src/view-adapters/phtml-view-adapter-2/src/PithPhtmlViewRunner2.php`
- `src/view-adapters/json-endpoint-view-adapter/src/PithJsonEndpointViewAdapter.php`
- `src/view-adapters/cli-view-adapter/src/PithCliViewAdapter.php`
- `vendor/pith/workflow-elements/src/base-workflow-elements/PithRoute.php`
- `src/framework/external/framework-engine-components/PithDispatcher.php`
- `src/plugins/panel-2/packs/panel-theme-pack/main-layout/MainLayoutRoute.php`
- `src/plugins/panel-2/packs/panel-pages-pack/account-bar/AccountBarPartialRoute.php`
- `src/plugins/user-system-5/src/user-system-5-pack/endpoints/create-new-user/CreateNewUserRoute.php`
