<?php

/**
 * Jello Partial Route
 * -------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

use Pith\Framework\PithRoute;

/**
 * Class JelloPartialRoute
 * @package Pith\ExampleAirshipPack
 */
class JelloPartialRoute extends PithRoute
{
    public $route_type   = 'partial';
    public $access_level = 'world';
    public $action       = '\\Pith\\ExampleAirshipPack\\DoNothingAction';
    public $preparer     = '\\Pith\\ExampleAirshipPack\\DoNothingPreparer';
    public $view         = 'experimental/packs/example-airship-pack/jello-partial/jello-partial-view.phtml';
    public $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}