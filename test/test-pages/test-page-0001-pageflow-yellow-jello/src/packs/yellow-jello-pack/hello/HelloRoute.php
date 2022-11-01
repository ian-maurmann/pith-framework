<?php

/**
 * Hello Route
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack;

use Pith\Framework\PithRoute;

/**
 * Class HelloRoute
 * @package Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack;
 */
class HelloRoute extends PithRoute
{
    public $route_type   = 'page';
    public $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\YellowJelloPack';
    public $access_level = 'world';
    public $action       = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\HelloAction';
    public $preparer     = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\HelloPreparer';
    public $view         = '[^pack_folder]/hello/hello-view.phtml';
    public $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
