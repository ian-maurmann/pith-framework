<?php

/**
 * Item Route
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageZero\RoutingSamplePack;

use Pith\Framework\PithRoute;

/**
 * Class ItemRoute
 * @package Pith\Framework\Test\TestPage\TestPageZero\RoutingSamplePack
 */
class ItemRoute extends PithRoute
{
    public $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageZero\\RoutingSamplePack\\RoutingSamplePack';
    public $route_type   = 'page';
    public $access_level = 'world';
    public $action       = '\\Pith\\Framework\\Test\\TestPage\\TestPageZero\\RoutingSamplePack\\ItemAction';
    public $preparer     = '\\Pith\\Framework\\Test\\TestPage\\TestPageZero\\RoutingSamplePack\\ItemPreparer';
    public $view         = '[^route_folder]/item-view.phtml';
    public $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}