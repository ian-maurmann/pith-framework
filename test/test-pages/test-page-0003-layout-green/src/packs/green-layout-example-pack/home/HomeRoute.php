<?php

/**
 * Home Route
 * ----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithRoute;

/**
 * Class HomeRoute
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;
 */
class HomeRoute extends PithRoute
{
    public $route_type   = 'page';
    public $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\GreenLayoutExamplePack';
    public $access_level = 'world';
    public $view         = '[^route_folder]/home-view.phtml';
    public $layout       = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\GreenLayoutRoute';
}
