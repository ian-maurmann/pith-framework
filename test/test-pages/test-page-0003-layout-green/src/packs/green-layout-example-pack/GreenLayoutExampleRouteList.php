<?php

/**
 * Green Layout Example Route List
 * -------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithRouteList;

/**
 * Class GreenLayoutExampleRouteList
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample
 */
class GreenLayoutExampleRouteList extends PithRouteList
{
    public $routes = [
        ['GET', '/',      '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\HomeRoute'],
        ['GET', '/hello', '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\HelloRoute'],
    ];
}