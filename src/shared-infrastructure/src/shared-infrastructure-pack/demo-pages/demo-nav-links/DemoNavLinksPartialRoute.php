<?php

/**
 * Demo Nav Links Partial Route
 * ----------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok here.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class DemoNavLinksPartialRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class DemoNavLinksPartialRoute extends PithRoute
{
    public string $route_type   = 'partial';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'world';
    public string $view         = '[^route_folder]/demo-nav-links-partial-view.phtml';
}