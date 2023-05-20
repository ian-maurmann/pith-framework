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
        ['route',       'GET', '',                                                      '\\Pith\\Framework\\SharedInfrastructure\\HomeRoute'],
        ['route',       'GET', '/demonstrate-fonts-work',                                '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateFontsWorkRoute'],
        ['route',       'GET', '/demonstrate-fontsheets',                                '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateFontsheetsRoute'],
        ['route',       'GET', '/demonstrate-libraries-work',                            '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibrariesWorkRoute'],
        ['route',       'GET', '/demonstrate-library/animate-css',                       '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryAnimateCssRoute'],
        ['route',       'GET', '/demonstrate-library/bootstrap-5',                       '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryBootstrap5Route'],
        ['route',       'GET', '/demonstrate-library/font-awesome-4',                    '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryFontAwesome4Route'],
        ['route',       'GET', '/demonstrate-library/font-awesome-4-compatibility-fork', '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryFontAwesome4CompatibilityForkRoute'],
        ['route',       'GET', '/demonstrate-library/font-awesome-6-free',               '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryFontAwesomeFree6Route'],
        ['route',       'GET', '/demonstrate-library/hoja',                              '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryHojaRoute'],
        ['route',       'GET', '/demonstrate-library/hoja-aquamarine',                   '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryHojaAquamarineRoute'],
        ['route',       'GET', '/demonstrate-library/hoja-blue',                         '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryHojaBlueRoute'],
        ['route',       'GET', '/demonstrate-library/jscrollpane',                       '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryJscrollpaneRoute'],
        ['route',       'GET', '/demonstrate-library/oxcss',                             '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryOxCssRoute'],
        ['route',       'GET', '/demonstrate-library/swal-2-na',                         '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibrarySwal2NaRoute'],
        ['route',       'GET', '/demonstrate-library/toastr',                            '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryToastrRoute'],
        ['route',       'GET', '/latte',                                                 '\\Pith\\Framework\\SharedInfrastructure\\LatteRoute'],
        ['route',       'GET', '/lorem-ipsum',                                           '\\Pith\\Framework\\SharedInfrastructure\\LoremIpsumRoute'],
        ['route',       'GET', '/quotes',                                                '\\Pith\\Framework\\SharedInfrastructure\\QuotesRoute'],
    ];
}