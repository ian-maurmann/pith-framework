<?php

/**
 * Demo-Pages Route List
 * ---------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRouteList;

/**
 * Class DemoPagesRouteList
 * @package Pith\Framework\SharedInfrastructure
 */
class DemoPagesRouteList extends PithRouteList
{
    public array $routes = [
        ['route',       'GET', '',                                   '\\Pith\\Framework\\SharedInfrastructure\\HomeRoute'],
        ['route-group', '',    '/demonstrate-front-end-integration', '\\Pith\\Framework\\SharedInfrastructure\\DemoPagesDemonstrateFrontEndIntegrationRouteList'],
        ['route',       'GET', '/latte',                             '\\Pith\\Framework\\SharedInfrastructure\\LatteRoute'],
        ['route',       'GET', '/lorem-ipsum',                       '\\Pith\\Framework\\SharedInfrastructure\\LoremIpsumRoute'],
        ['route',       'GET', '/new-user',                          '\\Pith\\Framework\\SharedInfrastructure\\NewUserRoute'],
        ['route',       'GET', '/quotes',                            '\\Pith\\Framework\\SharedInfrastructure\\QuotesRoute'],
    ];
}