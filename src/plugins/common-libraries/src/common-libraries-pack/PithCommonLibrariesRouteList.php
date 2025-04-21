<?php

/**
 * Pith Common Libraries route-list
 * --------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\Plugin\CommonLibraries;

use Pith\Workflow\PithRouteList;

/**
 * Class PithCommonLibrariesRouteList
 */
class PithCommonLibrariesRouteList extends PithRouteList
{
    public array $routes = [
        ['route', 'GET', '/aero-gel/{filepath:.+}',          '\\PithFront\\PithPackAeroGel\\AeroGelResourceRoute'],
        ['route', 'GET', '/animate.css/{filepath:.+}',       '\\PithFront\\PithPackAnimateCss\\AnimateCssResourceRoute'],
        ['route', 'GET', '/bootstrap/{filepath:.+}',         '\\PithFront\\PithPackBootstrap\\BootstrapResourceRoute'],
        ['route', 'GET', '/font-awesome/{filepath:.+}',      '\\PithFront\\PithPackFaIcons\\FaIconsResourceRoute'],
        ['route', 'GET', '/fixie-reset/{filepath:.+}',       '\\PithFront\\PithPackFixie\\FixieResourceRoute'],
        ['route', 'GET', '/hoja/{filepath:.+}',              '\\PithFront\\PithPackHojaRing\\HojaRingResourceRoute'],
        ['route', 'GET', '/ibm-plex/{filepath:.+}',          '\\PithFront\\PithPackPlex\\PlexResourceRoute'],
        ['route', 'GET', '/jetbrains-mono-nl/{filepath:.+}', '\\PithFront\\PithPackJbMonoNl\\JbMonoNlResourceRoute'],
        ['route', 'GET', '/jquery/{filepath:.+}',            '\\PithFront\\PithPackJquery\\JqueryResourceRoute'],
        ['route', 'GET', '/jscrollpane/{filepath:.+}',       '\\PithFront\\PithPackJscrollpane\\JscrollpaneResourceRoute'],
        ['route', 'GET', '/md-icons/{filepath:.+}',          '\\PithFront\\PithPackMdIcons\\MdIconsResourceRoute'],
        ['route', 'GET', '/oxcss/{filepath:.+}',             '\\PithFront\\PithPackOxcss\\OxcssResourceRoute'],
        ['route', 'GET', '/src-fallback/{filepath:.+}',      '\\PithFront\\PithPackSrcFallback\\SrcFallbackResourceRoute'],
        ['route', 'GET', '/sweetalert/{filepath:.+}',        '\\PithFront\\PithPackSwal\\SwalResourceRoute'],
        ['route', 'GET', '/toastr/{filepath:.+}',            '\\PithFront\\PithPackToastr\\ToastrResourceRoute'],
    ];
}