<?php

/**
 * Foo Resource Route
 * ------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\ExampleResourcePack;

use Pith\Framework\PithRoute;

/**
 * Class FooResourceRoute
 * @package Pith\ExampleResourcePack
 */
class FooResourceRoute extends PithRoute
{
    public $pack            = '\\Pith\\ExampleResourcePack\\ExampleResourcePack';
    public $route_type      = 'resource';
    public $access_level    = 'world';
    public $resource_folder = '[^route_folder]/vendor/foo-v0.0.0/';
}