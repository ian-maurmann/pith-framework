<?php

/**
 * Env Info - Route-List Route
 * ---------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages;

use Pith\Workflow\PithRoute;

/**
 * Class EnvInfoRouteListRoute
 * @package Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages
 */
class EnvInfoRouteListRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'dev-ip';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\Pages\\EnvInfoPages\\EnvInfoRouteListAction';
    public string $view         = '[^route_folder]/env-info-route-list-view.latte';
    public string $layout       = '\\Pith\\Framework\\SharedThemePack\\EnvInfoLayoutRoute';

    public string $page_title       = 'Env Info';
    public string $meta_keywords    = 'Env Info, demo, keyword, keywords';
    public string $meta_description = 'Env Info Page description here.';
}
