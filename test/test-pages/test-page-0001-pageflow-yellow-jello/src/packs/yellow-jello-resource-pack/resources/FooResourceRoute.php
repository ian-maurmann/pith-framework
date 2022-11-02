<?php

/**
 * Foo Resource Route
 * ------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageOne\YellowJelloResourcePack;

use Pith\Framework\PithRoute;

/**
 * Class FooResourceRoute
 * @package Pith\ExampleResourcePack
 */
class FooResourceRoute extends PithRoute
{
    public $pack            = 'Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloResourcePack\\YellowJelloResourcePack';
    public $route_type      = 'resource';
    public $access_level    = 'world';
    public $resource_folder = '[^route_folder]/3rd-party-libraries/foo-v0.0.0/';
}
