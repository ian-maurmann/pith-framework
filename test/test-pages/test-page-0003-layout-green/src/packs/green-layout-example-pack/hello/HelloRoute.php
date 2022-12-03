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
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\GreenLayoutExamplePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\HelloAction';
    public string $preparer     = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\HelloPreparer';
    public string $view         = '[^pack_folder]/hello/hello-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
