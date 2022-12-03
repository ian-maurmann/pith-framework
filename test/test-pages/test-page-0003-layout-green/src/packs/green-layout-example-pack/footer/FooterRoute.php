<?php

/**
 * Footer Route
 * ------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithRoute;

/**
 * Class FooterRoute
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;
 */
class FooterRoute extends PithRoute
{
    public string $route_type   = 'partial';
    public string $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\GreenLayoutExamplePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\FooterAction';
    public string $preparer     = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\FooterPreparer';
    public string $view         = '[^route_folder]/footer-view.phtml';
}
