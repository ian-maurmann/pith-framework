<?php

/**
 * Shared Infrastructure Route List
 * --------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRouteList;

/**
 * Class SharedInfrastructureRouteList
 * @package Pith\Framework\SharedInfrastructure
 */
class SharedInfrastructureRouteList extends PithRouteList
{
    public array $routes = [
        ['route-group', '',              PITH_DEMO_PAGES_ROUTE_GROUP_PATH,                            '\\Pith\\Framework\\SharedInfrastructure\\DemoPagesRouteList'],
        ['route-group', '',              PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH,                        '\\Pith\\Framework\\SharedInfrastructure\\Pages\\EnvInfoPages\\EnvInfoRouteList'],
        ['route-group', '',              PITH_USER_SYSTEM_AJAX_ENDPOINTS_PATH,                        '\\Pith\\Framework\\SharedInfrastructure\\Endpoints\\UserSystemAjaxEndpoints\\UserSystemAjaxEndpointsRouteList'],
        ['route-group', '',              PITH_PANEL_PATH,                                             '\\Pith\\Framework\\Panel\\PithPanelRouteList'],
        ['route-group', '',              TASKS_URL_PATH,                                              '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\TasksRouteList'],
        ['route',       'POST',          SHARED_UI_USER_LOGIN_FORM_ACTION_LINK,                       '\\Pith\\Framework\\SharedInfrastructure\\Pages\\SharedUiPages\\PerformUserLoginRoute'],
        ['route',       ['GET', 'POST'], SHARED_UI_USER_PERFORM_LOGOUT_LINK,                          '\\Pith\\Framework\\SharedInfrastructure\\Pages\\SharedUiPages\\PerformUserLogoutRoute'],
        ['route',       ['GET', 'POST'], '/',                                                         '\\Pith\\Framework\\SharedInfrastructure\\DefaultLandingRoute'],
        ['route',       ['GET', 'POST'], '/error-403',                                                '\\Pith\\Framework\\SharedInfrastructure\\Error403Route'],
        ['route',       ['GET', 'POST'], '/error-404',                                                '\\Pith\\Framework\\SharedInfrastructure\\Error404Route'],
        ['route',       ['GET', 'POST'], '/error-405',                                                '\\Pith\\Framework\\SharedInfrastructure\\Error405Route'],
        ['route',       'GET',           '/favicon.ico',                                              '\\Pith\\Framework\\SharedUiResourcePack\\PithFrameworkLogoFaviconIcoRoute'],
        ['route',       'GET',           '/resources/framework/plugin/login-form/{filepath:.+}',      '\\Pith\\Framework\\Plugin\\LoginForm\\PithLoginFormResourceRoute'],
        ['route',       'GET',           '/resources/framework/shared-ui/{filepath:.+}',              '\\Pith\\Framework\\SharedUiResourcePack\\SharedUiApplicationResourceRoute'],
        ['route',       'GET',           '/resources/vendor/common-fonts/{filepath:.+}',              '\\Pith\\Framework\\CommonFontsResourcePack\\CommonFontsResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/aero-gel/{filepath:.+}',          '\\PithFront\\PithPackAeroGel\\AeroGelResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/animate.css/{filepath:.+}',       '\\PithFront\\PithPackAnimateCss\\AnimateCssResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/bootstrap/{filepath:.+}',         '\\PithFront\\PithPackBootstrap\\BootstrapResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/font-awesome/{filepath:.+}',      '\\PithFront\\PithPackFaIcons\\FaIconsResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/fixie-reset/{filepath:.+}',       '\\PithFront\\PithPackFixie\\FixieResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/hoja/{filepath:.+}',              '\\PithFront\\PithPackHojaRing\\HojaRingResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/ibm-plex/{filepath:.+}',          '\\PithFront\\PithPackPlex\\PlexResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/jetbrains-mono-nl/{filepath:.+}', '\\PithFront\\PithPackJbMonoNl\\JbMonoNlResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/jquery/{filepath:.+}',            '\\PithFront\\PithPackJquery\\JqueryResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/jscrollpane/{filepath:.+}',       '\\PithFront\\PithPackJscrollpane\\JscrollpaneResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/md-icons/{filepath:.+}',          '\\PithFront\\PithPackMdIcons\\MdIconsResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/oxcss/{filepath:.+}',             '\\PithFront\\PithPackOxcss\\OxcssResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/src-fallback/{filepath:.+}',      '\\PithFront\\PithPackSrcFallback\\SrcFallbackResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/sweetalert/{filepath:.+}',        '\\PithFront\\PithPackSwal\\SwalResourceRoute'],
        ['route',       'GET',           '/resources/vendor/library/toastr/{filepath:.+}',            '\\PithFront\\PithPackToastr\\ToastrResourceRoute'],
    ];
}