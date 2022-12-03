<?php

/**
 * Jello Route
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack;

use Pith\Framework\PithRoute;

/**
 * Class JelloRoute
 * @package Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack
 */
class JelloRoute extends PithRoute
{
    public string $pack         = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\YellowJelloPack';
    public string $route_type   = 'page';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\JelloAction';
    public string $layout       = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\JelloLayoutRoute';
    public string $preparer     = '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\JelloPreparer';
    public string $view         = '[^route_folder]/jello-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}