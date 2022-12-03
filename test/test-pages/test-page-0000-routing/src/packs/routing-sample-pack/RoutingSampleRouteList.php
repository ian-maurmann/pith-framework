<?php

/**
 * Routing Sample Route List
 * -------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\Test\TestPage\TestPageZero\RoutingSamplePack;

use Pith\Framework\PithRouteList;

/**
 * Class RoutingSampleRouteList
 * @package Pith\Framework\Test\TestPage\TestPageZero\RoutingSamplePack
 */
class RoutingSampleRouteList extends PithRouteList
{
    public array $routes = [
        ['GET', '/',                                     '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\IndexRoute'],
        ['GET', '/hello',                                '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\HelloRoute'],
        ['GET', '/jello',                                '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloPack\\JelloRoute'],
        ['GET', '/library/foo/{filepath:.+}',            '\\Pith\\Framework\\Test\\TestPage\\TestPageOne\\YellowJelloResourcePack\\FooResourceRoute'],
        ['GET', '/item/{item_id:\d+}',                   '\\Pith\\Framework\\Test\\TestPage\\TestPageZero\\RoutingSamplePack\\ItemRoute'],
        ['GET', '/article/{article_id}/{article_title}', '\\Pith\\Framework\\Test\\TestPage\\TestPageZero\\RoutingSamplePack\\ArticleRoute'],
    ];
}