<?php

/**
 * Bottom Quote Route
 * ------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithRoute;

/**
 * Class BottomQuoteRoute
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;
 */
class BottomQuoteRoute extends PithRoute
{
    public string $route_type   = 'partial';
    public string $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\GreenLayoutExamplePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\BottomQuoteAction';
    public string $preparer     = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\BottomQuotePreparer';
    public string $view         = '[^route_folder]/bottom-quote-view.phtml';
}
