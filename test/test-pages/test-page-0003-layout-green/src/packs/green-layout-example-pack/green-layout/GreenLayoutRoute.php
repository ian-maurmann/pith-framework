<?php

/**
 * Green Layout Route
 * ------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithRoute;

/**
 * Class GreenLayoutRoute
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample
 */
class GreenLayoutRoute extends PithRoute
{
    public $pack             = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\GreenLayoutExamplePack';
    public $route_type       = 'layout';
    public $access_level     = 'world';
    public $view_requisition = '\\Pith\\Framework\\Test\\TestPage\\TestPageThree\\GreenLayoutExample\\GreenLayoutViewRequisition';
    public $view             = '[^route_folder]/green-layout-view.phtml';
}