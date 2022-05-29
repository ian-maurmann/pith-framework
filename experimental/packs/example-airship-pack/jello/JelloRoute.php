<?php

/**
 * Jello Route
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

use Pith\Framework\PithRoute;

/**
 * Class JelloRoute
 * @package Pith\ExampleAirshipPack
 */
class JelloRoute extends PithRoute
{
    public $pack         = '\\Pith\\ExampleAirshipPack\\ExampleAirshipPack';
    public $route_type   = 'page';
    public $access_level = 'world';
    public $action       = '\\Pith\\ExampleAirshipPack\\JelloAction';
    public $layout       = '\\Pith\\ExampleAirshipPack\\JelloLayoutRoute';
    public $preparer     = '\\Pith\\ExampleAirshipPack\\JelloPreparer';
    public $use_layout   = true;
    public $view         = '[^route_folder]/jello-view.phtml';
    public $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}