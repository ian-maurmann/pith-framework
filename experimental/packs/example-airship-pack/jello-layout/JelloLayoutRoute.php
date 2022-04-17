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
    public $route_type   = 'layout';
    public $access_level = 'world';
    public $action       = '\\Pith\\ExampleAirshipPack\\DoNothingAction';
    public $preparer     = '\\Pith\\ExampleAirshipPack\\DoNothingPreparer';
    public $view         = 'experimental/packs/example-airship-pack/jello-layout/jello-layout-view.phtml';
    public $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}