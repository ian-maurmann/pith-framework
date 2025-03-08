<?php

/**
 * Pith Login-Form resource route
 * ------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\LoginForm;

use Pith\Workflow\PithRoute;

/**
 * Class PithLoginFormResourceRoute
 */
class PithLoginFormResourceRoute extends PithRoute
{
    public string $pack            = 'Pith\\Framework\\Plugin\\LoginForm\\PithLoginFormPack';
    public string $route_type      = 'resource-folder';
    public string $access_level    = 'world';
    public string $resource_folder = '[^route_folder]/resources/';
    public string $cache_level     = 'Cache-Control: public, max-age=31536000, immutable, stale-while-revalidate=604800, stale-if-error=1209600';
}
