<?php

/**
 * Env Info Sidebar Partial Route
 * ------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages;

//use Pith\Framework\PithRoute;
use Pith\Workflow\PithRoute;


/**
 * Class EnvInfoSidebarPartialRoute
 * @package Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages
 */
class EnvInfoSidebarPartialRoute extends PithRoute
{
    public string $route_type   = 'partial';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\Pages\\EnvInfoPages\\EnvInfoSidebarPartialAction';
    public string $view         = '[^route_folder]/env-info-sidebar-view.latte';
    public string $layout       = '\\Pith\\Framework\\SharedThemePack\\EnvInfoLayoutRoute';
}
