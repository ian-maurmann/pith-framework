<?php

/**
 * Jello Layout Route
 * -------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack;

use Pith\Framework\PithRoute;

/**
 * Class JelloLayoutRoute
 * @package Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack
 */
class JelloLayoutRoute extends PithRoute
{
    public $pack             = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\YellowJelloPack';
    public $route_type       = 'layout';
    public $access_level     = 'world';
    public $view_requisition = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\JelloLayoutViewRequisition';
    public $view             = '[^pack_folder]/jello-layout/jello-layout-view.phtml';
    public $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}