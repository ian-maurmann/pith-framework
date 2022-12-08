<?php

/**
 * Yellow Jello Route List
 * --------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack;

use Pith\Framework\PithRouteList;

/**
 * Class YellowJelloRouteList
 * @package Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack
 */
class YellowJelloRouteList extends PithRouteList
{
    public array $routes = [
        ['GET', '/',                          '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\IndexRoute'],
        ['GET', '/hello',                     '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\HelloRoute'],
        ['GET', '/jello',                     '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\JelloRoute'],
        ['GET', '/library/foo/{filepath:.+}', '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloResourcePack\\FooResourceRoute'],
    ];
}