<?php

/**
 * Pith Framework Logo favicon.ico Route
 * -------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedUiResourcePack;

use Pith\Framework\PithRoute;

/**
 * Class PithFrameworkLogoFaviconIcoRoute
 * @package Pith\Framework\SharedUiResourcePack
 */
class PithFrameworkLogoFaviconIcoRoute extends PithRoute
{
    public string $route_type    = 'resource-file';
    public string $pack          = 'Pith\\Framework\\SharedUiResourcePack\\SharedUiResourcePack';
    public string $access_level  = 'world';
    public string $resource_path = '[^route_folder]/favicons/favicon.ico';
    public string $cache_level   = 'Cache-Control: public, max-age=31536000, immutable, stale-while-revalidate=604800, stale-if-error=1209600';
}
