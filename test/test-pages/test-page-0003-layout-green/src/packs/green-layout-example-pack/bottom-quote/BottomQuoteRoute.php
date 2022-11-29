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
    public $route_type   = 'partial';
    public $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\GreenLayoutExamplePack';
    public $access_level = 'world';
    public $action       = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\BottomQuoteAction';
    public $preparer     = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\BottomQuotePreparer';
    public $view         = '[^route_folder]/bottom-quote-view.phtml';
}
