<?php

/**
 * Shared UI Application Resource Route
 * ------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedUiResourcePack;

use Pith\Framework\PithRoute;

/**
 * Class SharedUiApplicationResourceRoute
 * @package Pith\Framework\SharedUiResourcePack
 */
class SharedUiApplicationResourceRoute extends PithRoute
{
    public string $pack            = 'Pith\\Framework\\SharedUiResourcePack\\SharedUiResourcePack';
    public string $route_type      = 'resource';
    public string $access_level    = 'world';
    public string $resource_folder = '[^route_folder]/application/';
}