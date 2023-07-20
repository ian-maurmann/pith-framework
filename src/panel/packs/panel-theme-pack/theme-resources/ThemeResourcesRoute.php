<?php

/**
 * Theme Resources Route
 * ---------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel\Theme;

use Pith\Framework\PithRoute;

/**
 * Class ThemeResourcesRoute
 * @package Pith\Framework\Panel\Theme
 */
class ThemeResourcesRoute extends PithRoute
{
    public string $pack            = 'Pith\\Framework\\Panel\\Theme\\PithPanelThemePack';
    public string $route_type      = 'resource-folder';
    public string $access_level    = 'world';
    public string $resource_folder = '[^route_folder]/resources/';
    public string $cache_level     = 'Cache-Control: public, max-age=31536000, immutable, stale-while-revalidate=604800, stale-if-error=1209600';
}
