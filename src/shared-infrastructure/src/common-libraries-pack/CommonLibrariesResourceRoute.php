<?php

/**
 * Shared UI Application Resource Route
 * ------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\CommonLibrariesResourcePack;

use Pith\Framework\PithRoute;

/**
 * Class SharedUiApplicationResourceRoute
 * @package Pith\Framework\SharedUiResourcePack
 */
class CommonLibrariesResourceRoute extends PithRoute
{
    public string $pack            = 'Pith\\Framework\\CommonLibrariesResourcePack\\CommonLibrariesResourcePack';
    public string $route_type      = 'resource';
    public string $access_level    = 'world';
    public string $resource_folder = '[^route_folder]/3rd-party-vendor-libraries/';
}