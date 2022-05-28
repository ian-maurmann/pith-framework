<?php

/**
 * Jello Layout Route
 * -------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

use Pith\Framework\PithRoute;

/**
 * Class JelloLayoutRoute
 * @package Pith\ExampleAirshipPack
 */
class JelloLayoutRoute extends PithRoute
{
    public $pack             = '\\Pith\\ExampleAirshipPack\\ExampleAirshipPack';
    public $route_type       = 'layout';
    public $access_level     = 'world';
    public $view_requisition = '\\Pith\\ExampleAirshipPack\\JelloLayoutViewRequisition';
    public $view             = '[^pack_folder]/jello-layout/jello-layout-view.phtml';
    public $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}