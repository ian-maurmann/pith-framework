<?php

/**
 * Error 404 Route
 * ---------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithRoute;

/**
 * Class Error404Route
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;
 */
class Error404Route extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\GreenLayoutExamplePack';
    public string $access_level = 'world';
    public string $view         = '[^route_folder]/error-404-view.phtml';
    public string $layout       = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\GreenLayoutRoute';

    public string $page_title = 'Green Layout Test Example';
}
