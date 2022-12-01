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
    public string $pack             = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\YellowJelloPack';
    public string $route_type       = 'partial';
    public string $access_level     = 'world';
    public string $view_requisition = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\JelloPartialViewRequisition';
    public string $view             = '[^route_folder]/jello-partial-view.phtml';
    public string $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
