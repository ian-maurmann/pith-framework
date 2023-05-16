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
        ['GET', '/',                                                      '\\Pith\\Framework\\SharedInfrastructure\\HomeRoute'],
        ['GET', '/11111/22222/env-info',                                  '\\Pith\\Framework\\SharedInfrastructure\\EnvInfoRoute'],
        ['GET', '/11111/22222/env-info/server-info',                      '\\Pith\\Framework\\SharedInfrastructure\\EnvInfoServerInfoRoute'],
        ['GET', '/demonstrate-fonts-work',                                '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateFontsWorkRoute'],
        ['GET', '/demonstrate-libraries-work',                            '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibrariesWorkRoute'],
        ['GET', '/demonstrate-library/animate-css',                       '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryAnimateCssRoute'],
        ['GET', '/demonstrate-library/bootstrap-5',                       '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryBootstrap5Route'],
        ['GET', '/demonstrate-library/font-awesome-4',                    '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryFontAwesome4Route'],
        ['GET', '/demonstrate-library/font-awesome-4-compatibility-fork', '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryFontAwesome4CompatibilityForkRoute'],
        ['GET', '/demonstrate-library/font-awesome-6-free',               '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryFontAwesomeFree6Route'],
        ['GET', '/demonstrate-library/hoja',                              '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryHojaRoute'],
        ['GET', '/demonstrate-library/hoja-aquamarine',                   '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryHojaAquamarineRoute'],
        ['GET', '/demonstrate-library/hoja-blue',                         '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryHojaBlueRoute'],
        ['GET', '/demonstrate-library/jscrollpane',                       '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryJscrollpaneRoute'],
        ['GET', '/demonstrate-library/oxcss',                             '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryOxCssRoute'],
        ['GET', '/demonstrate-library/swal-2-na',                         '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibrarySwal2NaRoute'],
        ['GET', '/demonstrate-library/toastr',                            '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryToastrRoute'],
        ['GET', '/error-404',                                             '\\Pith\\Framework\\SharedInfrastructure\\Error404Route'],
        ['GET', '/favicon.ico',                                           '\\Pith\\Framework\\SharedUiResourcePack\\PithFrameworkLogoFaviconIcoRoute'],
        ['GET', '/latte',                                                 '\\Pith\\Framework\\SharedInfrastructure\\LatteRoute'],
        ['GET', '/lorem-ipsum',                                           '\\Pith\\Framework\\SharedInfrastructure\\LoremIpsumRoute'],
        ['GET', '/resources/framework/shared-ui/{filepath:.+}',           '\\Pith\\Framework\\SharedUiResourcePack\\SharedUiApplicationResourceRoute'],
        ['GET', '/resources/vendor/common-fonts/{filepath:.+}',           '\\Pith\\Framework\\CommonFontsResourcePack\\CommonFontsResourceRoute'],
        ['GET', '/resources/vendor/common-libraries/{filepath:.+}',       '\\Pith\\Framework\\CommonLibrariesResourcePack\\CommonLibrariesResourceRoute'],
        ['GET', '/quotes',                                                '\\Pith\\Framework\\SharedInfrastructure\\QuotesRoute'],
    ];
}