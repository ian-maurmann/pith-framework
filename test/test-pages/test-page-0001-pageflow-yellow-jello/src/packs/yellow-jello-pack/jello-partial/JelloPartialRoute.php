<?php

/**
 * Jello Partial Route
 * -------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack;

use Pith\Framework\PithRoute;

/**
 * Class JelloPartialRoute
 * @package Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack
 */
class JelloPartialRoute extends PithRoute
{
    public $pack             = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\YellowJelloPack';
    public $route_type       = 'partial';
    public $access_level     = 'world';
    public $view_requisition = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\JelloPartialViewRequisition';
    public $view             = '[^route_folder]/jello-partial-view.phtml';
    public $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
