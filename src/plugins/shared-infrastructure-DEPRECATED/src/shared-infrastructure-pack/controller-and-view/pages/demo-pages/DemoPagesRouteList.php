<?php

/**
 * Demo-Pages Route List
 * ---------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRouteList;

/**
 * Class DemoPagesRouteList
 * @package Pith\Framework\SharedInfrastructure
 */
class DemoPagesRouteList extends PithRouteList
{
    public array $routes = [
        ['route',       'GET',  '',                                   '\\Pith\\Framework\\SharedInfrastructure\\HomeRoute'],
        ['route-group', '',     '/demonstrate-front-end-integration', '\\Pith\\Framework\\SharedInfrastructure\\DemoPagesDemonstrateFrontEndIntegrationRouteList'],
        ['route-group', '',     '/demonstrate-access-levels',         '\\Pith\\Framework\\SharedInfrastructure\\DemoPagesDemonstrateAccessLevelsRouteList'],
        ['route',       'GET',  '/latte',                             '\\Pith\\Framework\\SharedInfrastructure\\LatteRoute'],
        ['route',       'GET',  '/login',                             '\\Pith\\Framework\\SharedInfrastructure\\LoginRoute'],
        ['route',       'GET',  '/login-2',                           '\\Pith\\Framework\\SharedInfrastructure\\Login2Route'],
        ['route',       'GET',  '/lorem-ipsum',                       '\\Pith\\Framework\\SharedInfrastructure\\LoremIpsumRoute'],
        ['route',       'GET',  '/new-user',                          '\\Pith\\Framework\\SharedInfrastructure\\NewUserRoute'],
        ['route',       'GET',  '/quotes',                            '\\Pith\\Framework\\SharedInfrastructure\\QuotesRoute'],
        ['route',       'POST', '/send-test-email-endpoint',          '\\Pith\\Framework\\SharedInfrastructure\\SendTestEmailEndpointRoute'],
        ['route',       'GET',  '/sign-out',                          '\\Pith\\Framework\\SharedInfrastructure\\LogoutRoute'],
        ['route',       'GET',  '/test-email',                        '\\Pith\\Framework\\SharedInfrastructure\\TestEmailRoute'],
    ];
}