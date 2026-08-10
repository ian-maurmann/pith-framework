# Preparers

Preparers shape Action output for the view. A Preparer is a PHP class that extends `Pith\Workflow\PithPreparer`. The dispatcher runs it after the [Action](actions.md) and before the [View Requisition](view-requisitions.md) and [View](views.md).

Inside `runPreparer()`, read values from `$this->prepare`, then cast, escape, or reshape them onto `$this->view`. Those view variables are passed to the [View Adapter](view-adapters.md).

With Latte (the default adapter), a custom Preparer is usually not needed. Latte applies contextual escaping in the template, so the default `PassThroughPreparer`—which copies `$prepare` into `$view` unchanged—is enough for most Latte Routes. Custom Preparers matter most for PHTML (manual escaping) or when you need casting or reshaping before any adapter.

## Base type

`PithPreparer` is intentionally small:

```php
class PithPreparer extends PithWorkflowElement
{
    public string $element_type = 'preparer';

    public PithEscapeUtility $escape;

    protected object $prepare;
    protected object $view;

    public function provisionPreparer(object $prepare_vars_object, PithDependencyInjection $dependency_injection, PithEscapeUtility $escape)
    {
        $this->prepare              = $prepare_vars_object;
        $this->view                 = (object)[];
        $this->escape               = $escape;
        $this->dependency_injection = $dependency_injection;
    }

    public function getVariablesForView(): object
    {
        return $this->view;
    }

    public function runPreparer()
    {
        // Do nothing
    }
}
```

## Defining a Preparer

Extend `PithPreparer`, override `runPreparer()`, cast and escape from `$this->prepare`, and assign onto `$this->view`:

```php
namespace FooOrganization\FooProject;

use Pith\Workflow\PithPreparer;

class FooterPreparer extends PithPreparer
{
    public function runPreparer()
    {
        $version_text    = (string) $this->prepare->version_text;
        $copyright_years = (string) $this->prepare->copyright_years;

        $this->view->version_text    = $this->escape->html($version_text);
        $this->view->copyright_years = $this->escape->html($copyright_years);
    }
}
```

Keep business logic and side effects in the Action. Use the Preparer only for presentation shaping. `$this->escape` is provisioned by the dispatcher (via `PithEscapeUtility`); you do not inject it in the constructor.

## Wiring from a Route

Point the Route’s `$preparer` property at the Preparer class:

```php
class FooterRoute extends PithRoute
{
    public string $route_type   = 'partial';
    public string $pack         = '\\FooOrganization\\FooProject\\FooPack';
    public string $access_level = 'world';
    public string $action       = '\\FooOrganization\\FooProject\\FooterAction';
    public string $preparer     = '\\FooOrganization\\FooProject\\FooterPreparer';
    public string $view         = '[^route_folder]/footer-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
```

If `$preparer` is omitted, the Route defaults to `\\Pith\\Workflow\\GracefulFallback\\PassThroughPreparer`, which assigns `$this->view = $this->prepare` so prepare properties become view variables as-is. For Latte pages and JSON endpoints, omitting `$preparer` is the usual pattern.

Listing the Preparer FQCN on the Route is enough—there is no separate Preparer registry. Keep the class PSR-4 autoloadable so PHP-DI can load it.

## How it runs

After the Action fills `$prepare`:

1. `PithDispatcher` calls `tapPreparer($route, $variables_for_prepare)`.
2. `$route->getPreparer()` resolves `$preparer` via PHP-DI.
3. `provisionPreparer(...)` sets `$this->prepare`, resets `$this->view` to an empty object, and injects `$this->escape`.
4. `runPreparer()` runs your casting, escaping, and reshaping.
5. `getVariablesForView()` returns `$this->view`.
6. Those variables are passed to the View Adapter via `setVars(...)`.

Preparers run for `page`, `error-page`, `layout`, `partial`, `endpoint`, `task`, and `job` routes. Static `resource-folder` / `resource-file` routes do not go through the Preparer path. Partials invoked via `$engine->runPartial(...)` still run Action → Preparer → View. Layouts and content pages each run their own Action → Preparer → View.

## Defaults

| Preparer | Behavior |
|----------|----------|
| `PassThroughPreparer` | Route default; `$this->view = $this->prepare` (same object) |
| `EmptyPreparer` | Leaves `$view` empty; not the Route default |

Prefer `PassThroughPreparer` (or omit `$preparer`) unless you need a custom Preparer.

## Latte vs PHTML

**Latte:** Templates receive variables as `$name` and escape them based on context. Push data from the Action with `$this->prepare->…` and omit `$preparer`. A custom Preparer is rarely useful for escaping when Latte is the adapter.

**PHTML:** The adapter `extract()`s Preparer variables into local scope. Escape in the Preparer with `$this->escape->html(...)`, and/or in the view the same way. Custom Preparers are the natural place for that HTML escaping.

JSON and CLI adapters typically rely on pass-through as well (for example, the Action sets `$this->prepare->response` and the JSON adapter reads it from the view variables).

## Conventions

- Name classes `*Preparer`.
- Override `runPreparer()`; leave `provisionPreparer()` / `getVariablesForView()` alone unless you have a specific reason.
- Keep business logic in the Action; use the Preparer to cast, escape, and shape for the view.
- Prefer omitting `$preparer` for Latte Routes; Latte’s contextual escaping covers most escaping needs.
- Use `$this->escape->html(...)` when escaping manually (PHTML).
- Use double-backslash FQCNs in PHP strings (`'\\Pith\\...'`).
- Keep Preparers PSR-4 autoloadable; wiring them on the Route is registration.

## Related pieces

| Piece | Role |
|-------|------|
| `PithPreparer` | Base class; consumes `$prepare` and builds `$view` |
| [Routes](routes.md) (`PithRoute`) | Declares `$preparer` FQCN; loads the Preparer |
| [Actions](actions.md) (`PithAction`) | Fills `$prepare` for the Preparer |
| [Views](views.md) | Render end; receives Preparer `$view` variables |
| [View Adapters](view-adapters.md) | Render backends; `setVars` from Preparer output |
| [View Requisitions](view-requisitions.md) | Headers and assets; runs after the Preparer |
| `PassThroughPreparer` | Default Preparer; copies prepare → view |
| `EmptyPreparer` | No-op Preparer; leaves `$view` empty |
| `PithEscapeUtility` | `$this->escape->html(...)` helper |
| `PithDispatcher` | Runs `tapAction` → `tapPreparer` → view |

## Important source files

- `vendor/pith/workflow-elements/src/base-workflow-elements/PithPreparer.php`
- `vendor/pith/workflow-elements/src/base-workflow-elements/PithRoute.php`
- `vendor/pith/workflow-elements/src/fallback-workflow-elements/PassThroughPreparer.php`
- `vendor/pith/workflow-elements/src/fallback-workflow-elements/EmptyPreparer.php`
- `vendor/pith/base/src/utilities/PithEscapeUtility.php`
- `src/framework/external/framework-engine-components/PithDispatcher.php`
- `src/plugins/panel-2/packs/panel-pages-pack/tasks/TasksAction.php`
- `src/plugins/shared-infrastructure-DEPRECATED/src/shared-infrastructure-pack/controller-and-view/pages/demo-pages/footer/FooterPreparer.php`
