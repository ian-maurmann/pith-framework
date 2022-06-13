<?php

/**
 * Example Airship Route List
 * --------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\ExampleAirshipPack;

use Pith\Framework\PithRouteList;

/**
 * Class PithRouteList
 * @package Pith\ExampleAirshipPack
 */
class ExampleAirshipRouteList extends PithRouteList
{
    public $routes = [
        ['GET', '/',                          '\\Pith\\ExampleAirshipPack\\IndexRoute'],
        ['GET', '/airship/hindenburg',        '\\Pith\\ExampleAirshipPack\\HindenburgRoute'],
        ['GET', '/jello',                     '\\Pith\\ExampleAirshipPack\\JelloRoute'],
        ['GET', '/library/foo/{filepath:.+}', '\\Pith\\ExampleResourcePack\\FooResourceRoute'],
    ];
}