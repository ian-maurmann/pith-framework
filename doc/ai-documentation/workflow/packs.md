# Packs

A Pack is a thin workflow marker that anchors a feature folder. It extends `Pith\Workflow\PithPack` and supplies the pack directory so the dispatcher can resolve path expressions like `[^pack_folder]`.

Packs group related [Routes](routes.md)—pages, layouts, partials, endpoints, tasks, and static resources—under one filesystem root. A Pack is not a controller, router, or service container. Application logic stays on Actions and services; the Pack’s job is to mark the folder.

## Base type

`PithPack` is intentionally small:

```php
class PithPack extends PithWorkflowElement
{
    use PithGetObjectClassDirectoryTrait;

    public string $element_type = 'pack';

    public function getPackFolder(): string
    {
        return $this->getObjectClassDirectoryRelativePath();
    }
}
```

`getPackFolder()` uses reflection on the Pack class file and returns a path relative to the process working directory (`getcwd()`). That path becomes `[^pack_folder]` when views and resources are resolved.

## Defining a Pack

Extend `PithPack` and keep the class next to the features it owns:

```php
namespace FooOrganization\FooProject;

use Pith\Workflow\PithPack;

class FooPack extends PithPack
{
    public string $access_level = 'world';
}
```

There is no Pack registry. Make the class PSR-4 autoloadable and point each Route’s `$pack` at the Pack FQCN—that is registration.

Optional properties seen on Pack subclasses:

| Property | Used by the engine? | Notes |
|----------|---------------------|-------|
| `$access_level` | No (at Pack load) | Inherited from `PithWorkflowElement`; access is checked on the **Route**—see [Access Levels](access-levels.md) |
| `$pack_type` | No | Conventional marker on front-end resource packs (for example `'resource-pack'`) |

## Folder layout

App Pack scaffold (from setup templates / `PithSetup`):

```
src/{app}-pack/
  {App}Pack.php          ← Pack class (folder root)
  features/              ← pages, layouts, partials
    home/
    main-layout/
    ...
  resources/             ← static assets + resource Routes
  services/              ← app services
```

Plugins often use `src/plugins/{plugin}/src/{name}-pack/`. Larger plugins may ship more than one Pack (for example panel pages vs panel theme).

Composer `autoload.psr-4` often maps one namespace to the Pack root **and** each feature subdirectory, so classes can share a flat namespace even when files live in subfolders.

## Wiring from a Route

Every Route that needs a pack folder sets `$pack`:

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

A page Route and its layout Route may declare different Packs. Here the page uses the pages Pack; the layout uses the theme Pack.

Resource Routes use the same `$pack` field:

```php
class ThemeResourcesRoute extends PithRoute
{
    public string $route_type      = 'resource-folder';
    public string $pack            = '\\Pith\\Framework\\Panel\\Theme\\PithPanelThemePack';
    public string $access_level    = 'world';
    public string $resource_folder = '[^route_folder]/resources/';
}
```

## Path expressions

View and resource paths are expressions, not raw absolute paths:

- `[^route_folder]` — directory of the Route class file
- `[^pack_folder]` — directory of the Pack class file (pack root)

Prefer `[^route_folder]` when the view or resource folder sits beside the Route. Use `[^pack_folder]` for paths relative to the Pack class file.

`PithExpressionUtility::getViewPathFromExpression(...)` performs the substitution once the dispatcher has both folders.

## How the dispatcher uses Packs

On a matched (or programmatically run) Route:

1. `tapRoute` — inject DI into the Route; resolve `route_folder`
2. `tapPack` — `$route->getPack()` loads the Pack via PHP-DI; `getPackFolder()` sets `pack_folder`
3. Later taps resolve view / resource path expressions with those folders

Pack loading failures from `PithRoute::getPack`:

| Code | Meaning |
|------|---------|
| 4017 | Route has no Pack |
| 4018 | DI `DependencyException` loading Pack |
| 4019 | DI `NotFoundException` loading Pack |

Packs are not listed in a DI definitions file. PHP-DI autowires them from the FQCN on the Route.

Workflow order for a normal (non-resource) Route: **Route → Pack → Access → Action → Preparer → View Requisition → Responder → View**.

## Front-end resource Packs

Front-end libraries often ship as Composer packages under `pith-front/pith-pack-*`. Each package typically contains:

- A Pack class (often with `$pack_type = 'resource-pack'`)
- A `resource-folder` Route pointing at assets
- Static files under that folder

Mount the resource Route from a [Route List](route-lists.md) (for example under `/jquery/{filepath:.+}`), and pull scripts or styles in from View Requisitions. Same `PithPack` mechanism as app Packs; different distribution.

## Conventions

- Name classes `*Pack` or `*ResourcePack`; folders often `*-pack`.
- Place the Pack class at the root of the feature tree it owns.
- Always set Route `$pack` to the Pack FQCN.
- Prefer `[^route_folder]` for views and resources next to the Route; use `[^pack_folder]` for pack-root-relative paths.
- Secure access on the **Route** `$access_level`, not the Pack—see [Access Levels](access-levels.md).
- Use double-backslash FQCNs in PHP strings (`'\\Pith\\...'`).
- Keep Packs PSR-4 autoloadable; wiring them on Routes is enough—no separate registrar.

## Related pieces

| Piece | Role |
|-------|------|
| `PithPack` | Feature pack; supplies pack folder |
| [Routes](routes.md) (`PithRoute`) | Declares `$pack` FQCN; loads the Pack |
| [Access Levels](access-levels.md) | Route gate; Pack `$access_level` is not enforced at Pack load |
| [Route Lists](route-lists.md) | Maps URLs to Route FQCNs (not Packs) |
| [Actions](actions.md) (`PithAction`) | Application logic; lives in the same feature tree |
| `PithExpressionUtility` | Substitutes `[^pack_folder]` / `[^route_folder]` |
| `PithDispatcher` | Runs `tapPack` early in the Route pipeline |
| `PithGetObjectClassDirectoryTrait` | Reflection → directory of the class file |

## Important source files

- `vendor/pith/workflow-elements/src/base-workflow-elements/PithPack.php`
- `vendor/pith/workflow-elements/src/base-workflow-elements/PithRoute.php`
- `src/framework/external/framework-engine-components/PithDispatcher.php`
- `src/framework/internal/utilities/PithExpressionUtility.php`
- `src/plugins/panel-2/packs/panel-pages-pack/PithPanelPagesPack.php`
- `src/plugins/panel-2/packs/panel-theme-pack/PithPanelThemePack.php`
- `src/plugins/panel-2/packs/panel-pages-pack/home/HomeRoute.php`
- `config/setup-templates/for-pack/app-pack.setup.dist.txt`
