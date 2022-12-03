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
    public string $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageZero\\RoutingSamplePack\\RoutingSamplePack';
    public string $route_type   = 'page';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\Test\\TestPage\\TestPageZero\\RoutingSamplePack\\ItemAction';
    public string $preparer     = '\\Pith\\Framework\\Test\\TestPage\\TestPageZero\\RoutingSamplePack\\ItemPreparer';
    public string $view         = '[^route_folder]/item-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}