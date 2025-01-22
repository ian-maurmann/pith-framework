<?php

/**
 * Default Landing Route
 * ---------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRoute;

/**
 * Class DefaultLandingRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class DefaultLandingRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'dev-ip';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\DefaultLandingAction';
    public string $view         = '[^route_folder]/default-landing-view.latte';
    public string $layout       = '\\Pith\\Framework\\SharedThemePack\\DefaultLandingLayoutRoute';

    public string $page_title       = 'Pith Framework - Shared Infrastructure';
    public string $meta_keywords    = 'Pith Framework Shared Infrastructure, demo, keyword, keywords';
    public string $meta_description = 'Pith Framework Shared Infrastructure Page description here.';
}
