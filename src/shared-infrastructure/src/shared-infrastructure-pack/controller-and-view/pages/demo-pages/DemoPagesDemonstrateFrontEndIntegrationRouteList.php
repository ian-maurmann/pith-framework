<?php

/**
 * Demo-Pages: Demonstrate Front-End Integration Route List
 * --------------------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRouteList;

/**
 * Class DemoPagesDemonstrateFrontEndIntegrationRouteList
 * @package Pith\Framework\SharedInfrastructure
 */
class DemoPagesDemonstrateFrontEndIntegrationRouteList extends PithRouteList
{
    public array $routes = [
        ['route',       'GET', '',                                   '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibrariesWorkRoute'],
        ['route',       'GET', '/demonstrate-fonts-work',            '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateFontsWorkRoute'],
        ['route',       'GET', '/demonstrate-fontsheets',            '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateFontsheetsRoute'],
        ['route',       'GET', '/animate-css',                       '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryAnimateCssRoute'],
        ['route',       'GET', '/bootstrap-5',                       '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryBootstrap5Route'],
        ['route',       'GET', '/font-awesome-4',                    '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryFontAwesome4Route'],
        ['route',       'GET', '/font-awesome-4-compatibility-fork', '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryFontAwesome4CompatibilityForkRoute'],
        ['route',       'GET', '/font-awesome-6-free',               '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryFontAwesomeFree6Route'],
        ['route',       'GET', '/hoja',                              '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryHojaRoute'],
        ['route',       'GET', '/hoja-aquamarine',                   '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryHojaAquamarineRoute'],
        ['route',       'GET', '/hoja-blue',                         '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryHojaBlueRoute'],
        ['route',       'GET', '/jscrollpane',                       '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryJscrollpaneRoute'],
        ['route',       'GET', '/oxcss',                             '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryOxCssRoute'],
        ['route',       'GET', '/swal-2-na',                         '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibrarySwal2NaRoute'],
        ['route',       'GET', '/toastr',                            '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryToastrRoute'],
    ];
}