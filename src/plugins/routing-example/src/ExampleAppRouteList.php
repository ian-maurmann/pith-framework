<?php

/**
 * Example App Route-List
 * ----------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */

declare(strict_types=1);

namespace Pith\Framework\Plugin\RoutingExample;

use Pith\Workflow\PithRouteList;

/**
 * Class ExampleAppRouteList
 */
class ExampleAppRouteList extends PithRouteList
{
    public array $routes = [
        ['route-group', '',              PITH_DEMO_PAGES_ROUTE_GROUP_PATH,                            '\\Pith\\Framework\\SharedInfrastructure\\DemoPagesRouteList'],
        ['route-group', '',              PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH,                        '\\Pith\\Framework\\SharedInfrastructure\\Pages\\EnvInfoPages\\EnvInfoRouteList'],
     // ['route-group', '',              PITH_USER_SYSTEM_AJAX_ENDPOINTS_PATH,                        '\\Pith\\Framework\\SharedInfrastructure\\Endpoints\\UserSystemAjaxEndpoints\\UserSystemAjaxEndpointsRouteList'],
        ['route-group', '',              PITH_USER_SYSTEM_AJAX_ENDPOINTS_PATH,                        '\\Pith\\Framework\\Plugin\\UserSystem4\\UserSystemAjaxEndpointsRouteList'],
        ['route-group', '',              PITH_PANEL_PATH,                                             '\\Pith\\Framework\\Panel\\PithPanelRouteList'],
     // ['route-group', '',              TASKS_URL_PATH,                                              '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\TasksRouteList'],
     // ['route',       'POST',          SHARED_UI_USER_LOGIN_FORM_ACTION_LINK,                       '\\Pith\\Framework\\SharedInfrastructure\\Pages\\SharedUiPages\\PerformUserLoginRoute'],
        ['route',       'POST',          SHARED_UI_USER_LOGIN_FORM_ACTION_LINK,                       '\\Pith\\Framework\\Plugin\\Session\\PerformUserLoginRoute'],
     // ['route',       ['GET', 'POST'], SHARED_UI_USER_PERFORM_LOGOUT_LINK,                          '\\Pith\\Framework\\SharedInfrastructure\\Pages\\SharedUiPages\\PerformUserLogoutRoute'],
     // ['route',       ['GET', 'POST'], SHARED_UI_USER_PERFORM_LOGOUT_LINK,                          '\\Pith\\Framework\\Plugin\\Session\\PerformUserLogoutRoute'],
        ['route',       ['GET', 'POST'], '/',                                                         '\\Pith\\Framework\\SharedInfrastructure\\DefaultLandingRoute'],
        ['route',       ['GET', 'POST'], '/error-403',                                                '\\Pith\\Framework\\Plugin\\ErrorPages\\Error403Route'],
        ['route',       ['GET', 'POST'], '/error-404',                                                '\\Pith\\Framework\\Plugin\\ErrorPages\\Error404Route'],
        ['route',       ['GET', 'POST'], '/error-405',                                                '\\Pith\\Framework\\Plugin\\ErrorPages\\Error405Route'],
        ['route',       'GET',           '/favicon.ico',                                              '\\Pith\\Framework\\SharedUiResourcePack\\PithFrameworkLogoFaviconIcoRoute'],
        ['route',       'GET',           '/resources/framework/plugin/login-form/{filepath:.+}',      '\\Pith\\Framework\\Plugin\\LoginForm\\PithLoginFormResourceRoute'],
        ['route',       'GET',           '/resources/framework/plugin/sign-up-form/{filepath:.+}',    '\Pith\Framework\Plugin\SignUpForm\PithSignUpFormResourceRoute'],
        ['route',       'GET',           '/resources/framework/shared-ui/{filepath:.+}',              '\\Pith\\Framework\\SharedUiResourcePack\\SharedUiApplicationResourceRoute'],
        ['route',       'GET',           '/resources/vendor/common-fonts/{filepath:.+}',              '\\Pith\\Framework\\CommonFontsResourcePack\\CommonFontsResourceRoute'], // Will change
        ['route-group', '',              '/resources/vendor/common-libraries',                        '\\Pith\\Framework\\Plugin\\CommonLibraries\\PithCommonLibrariesRouteList'],
    ];
}