<?php

/**
 * Index Route
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

use Pith\Framework\PithRoute;

/**
 * Class IndexRoute
 * @package Pith\ExampleAirshipPack
 */
class IndexRoute extends PithRoute
{
    public $route_type   = 'page';
    public $access_level = 'world';
    public $action       = '\\Pith\\ExampleAirshipPack\\HelloAction';
    public $preparer     = '\\Pith\\ExampleAirshipPack\\HelloPreparer';
    public $view         = 'experimental/packs/example-airship-pack/hello-view.phtml';
    public $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}