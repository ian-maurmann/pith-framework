<?php

/**
 * Index Route
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageZero\RoutingSamplePack;

use Pith\Framework\PithRoute;

/**
 * Class IndexRoute
 * @package Pith\Framework\Test\TestPage\TestPageZero\RoutingSamplePack
 */
class IndexRoute extends PithRoute
{
    public $route_type   = 'page';
    public $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageZero\\RoutingSamplePack\\RoutingSamplePack';
    public $access_level = 'world';
    public $action       = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\HelloAction';
    public $preparer     = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\HelloPreparer';
    public $view         = '[^pack_folder]/hello/hello-view.phtml';
    public $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
