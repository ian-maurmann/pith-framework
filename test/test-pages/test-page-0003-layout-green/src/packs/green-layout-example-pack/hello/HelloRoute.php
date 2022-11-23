<?php

/**
 * Hello Route
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithRoute;

/**
 * Class HelloRoute
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;
 */
class HelloRoute extends PithRoute
{
    public $route_type   = 'page';
    public $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\GreenLayoutExamplePack';
    public $access_level = 'world';
    public $action       = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\HelloAction';
    public $preparer     = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\HelloPreparer';
    public $view         = '[^pack_folder]/hello/hello-view.phtml';
    public $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
