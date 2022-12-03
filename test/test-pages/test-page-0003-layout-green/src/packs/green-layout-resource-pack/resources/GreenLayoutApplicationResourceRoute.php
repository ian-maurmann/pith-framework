<?php

/**
 * Green Layout Application Resource Route
 * ---------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithRoute;

/**
 * Class GreenLayoutApplicationResourceRoute
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample
 */
class GreenLayoutApplicationResourceRoute extends PithRoute
{
    public string $pack            = 'Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\GreenLayoutResourcePack';
    public string $route_type      = 'resource';
    public string $access_level    = 'world';
    public string $resource_folder = '[^route_folder]/application/';
}
