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
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageZero\\RoutingSamplePack\\RoutingSamplePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\HelloAction';
    public string $preparer     = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\HelloPreparer';
    public string $view         = '[^pack_folder]/hello/hello-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
