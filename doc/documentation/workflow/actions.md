# Actions

Actions hold a route’s application logic—loading data, handling the request, and running side effects. An Action is a PHP class that extends `Pith\Workflow\PithAction`. The dispatcher runs it after access control and before the [Preparer](preparers.md).

Inside `runAction()`, push values onto `$this->prepare`. Those values are handed to the [Preparer](preparers.md), which shapes them for the view.

## Base type

`PithAction` is intentionally small:

```php
class PithAction extends PithWorkflowElement
{
    public string $element_type = 'action';

    protected object $prepare;

    public function provisionAction()
    {
        $this->prepare = (object)[];
    }

    public function getVariablesForPrepare(): object
    {
        return $this->prepare;
    }

    public function runAction()
    {
        // Do nothing
    }
}
```

## Defining an Action

Extend `PithAction`, inject dependencies in the constructor, override `runAction()`, and assign properties on `$this->prepare`:

```php
namespace FooOrganization\FooProject;

use Pith\Workflow\PithAction;

class FooterAction extends PithAction
{
    private CopyrightYearUtility $copyright_year_utility;

    public function __construct(CopyrightYearUtility $copyright_year_utility)
    {
        $this->copyright_year_utility = $copyright_year_utility;
    }

    public function runAction()
    {
        $copyright_years = $this->copyright_year_utility->getYearsByFirstYear(PITH_APP_COPYRIGHT_NOTICE_START_YEAR);

        // Push to Preparer
        $this->prepare->copyright_years = $copyright_years;
    }
}
```

PHP-DI builds the Action from its FQCN, so constructor parameters are autowired when the class is resolvable.

## Wiring from a Route

Point the Route’s `$action` property at the Action class:

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

If `$action` is omitted, the Route defaults to `\\Pith\\Workflow\\GracefulFallback\\EmptyAction`, a no-op Action. The Preparer defaults to `PassThroughPreparer`, which copies `$prepare` into `$view` unchanged.

Listing the Action FQCN on the Route is enough—there is no separate Action registry. Keep the class PSR-4 autoloadable so PHP-DI can load it.

## How it runs

After the router matches a Route and access is checked:

1. `PithDispatcher` calls `tapAction($route)`.
2. `$route->getAction()` resolves `$action` via PHP-DI.
3. `provisionAction()` sets `$this->prepare` to an empty object.
4. `runAction()` runs your logic and fills `$this->prepare`.
5. `getVariablesForPrepare()` returns that object.
6. `tapPreparer(...)` provisions and runs the Preparer, then the view renders.

Actions run for `page`, `error-page`, `layout`, `partial`, `endpoint`, `task`, and `job` routes. Static `resource-folder` / `resource-file` routes do not go through the Action path. Partials invoked via `$engine->runPartial(...)` still run Action → Preparer → View.

## Action and Preparer

Keep business logic and side effects in the Action. Use the [Preparer](preparers.md) to cast, escape, and shape data for the view.

Action:

```php
$this->prepare->version_text    = $version_text;
$this->prepare->copyright_years = $copyright_years;
```

Custom Preparer:

```php
$version_text    = (string) $this->prepare->version_text;
$copyright_years = (string) $this->prepare->copyright_years;

$this->view->version_text    = $this->escape->html($version_text);
$this->view->copyright_years = $this->escape->html($copyright_years);
```

With the default `PassThroughPreparer`, prepare properties become view variables as-is, so a custom Preparer is often not needed.

## Conventions

- Name classes `*Action`.
- Override `runAction()`; leave `provisionAction()` / `getVariablesForPrepare()` alone unless you have a specific reason.
- Inject services through the constructor (PHP-DI).
- Push data for the Preparer with `$this->prepare->…`.
- Use double-backslash FQCNs in PHP strings (`'\\Pith\\...'`).
- Keep Actions PSR-4 autoloadable; wiring them on the Route is registration.

## Related pieces

| Piece | Role |
|-------|------|
| `PithAction` | Base class for route application logic |
| `PithRoute` | Declares `$action` FQCN; loads the Action |
| [Packs](packs.md) (`PithPack`) | Feature pack; supplies pack folder |
| [Route Lists](route-lists.md) | Maps URLs to Route classes |
| [Preparers](preparers.md) (`PithPreparer`) | Consumes `$prepare` and builds `$view` |
| `EmptyAction` | Default no-op Action |
| [Preparers](preparers.md) (`PassThroughPreparer`) | Default Preparer; copies prepare → view |
| `PithDispatcher` | Runs `tapAccess` → `tapAction` → `tapPreparer` → view |

## Important source files

- `vendor/pith/workflow-elements/src/base-workflow-elements/PithAction.php`
- `vendor/pith/workflow-elements/src/base-workflow-elements/PithRoute.php`
- `vendor/pith/workflow-elements/src/fallback-workflow-elements/EmptyAction.php`
- `vendor/pith/workflow-elements/src/fallback-workflow-elements/PassThroughPreparer.php`
- `src/framework/external/framework-engine-components/PithDispatcher.php`
- `src/plugins/panel-2/packs/panel-pages-pack/home/HomeAction.php`
- `config/setup-templates/for-pack/for-footer/FooterAction.setup.dist.txt`
