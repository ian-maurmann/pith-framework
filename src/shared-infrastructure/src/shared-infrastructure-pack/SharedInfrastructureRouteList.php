<?php

/**
 * Shared Infrastructure Route List
 * --------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRouteList;

/**
 * Class SharedInfrastructureRouteList
 * @package Pith\Framework\SharedInfrastructure
 */
class SharedInfrastructureRouteList extends PithRouteList
{
    public array $routes = [
        ['route-group', '',    PITH_DEMO_PAGES_ROUTE_GROUP_PATH,                   '\\Pith\\Framework\\SharedInfrastructure\\DemoPagesRouteList'],
        ['route-group', '',    PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH,               '\\Pith\\Framework\\SharedInfrastructure\\EnvInfoRouteList'],
        ['route',       'GET', '/error-404',                                       '\\Pith\\Framework\\SharedInfrastructure\\Error404Route'],
        ['route',       'GET', '/favicon.ico',                                     '\\Pith\\Framework\\SharedUiResourcePack\\PithFrameworkLogoFaviconIcoRoute'],
        ['route',       'GET', '/resources/framework/shared-ui/{filepath:.+}',     '\\Pith\\Framework\\SharedUiResourcePack\\SharedUiApplicationResourceRoute'],
        ['route',       'GET', '/resources/vendor/common-fonts/{filepath:.+}',     '\\Pith\\Framework\\CommonFontsResourcePack\\CommonFontsResourceRoute'],
        ['route',       'GET', '/resources/vendor/common-libraries/{filepath:.+}', '\\Pith\\Framework\\CommonLibrariesResourcePack\\CommonLibrariesResourceRoute'],
    ];
}