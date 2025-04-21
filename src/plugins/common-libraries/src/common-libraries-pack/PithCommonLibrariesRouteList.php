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
        ['route', 'GET', '/aero-gel/{filepath:.+}',    '\\PithFront\\PithPackAeroGel\\AeroGelResourceRoute'],
        ['route', 'GET', '/animate.css/{filepath:.+}', '\\PithFront\\PithPackAnimateCss\\AnimateCssResourceRoute'],
    ];
}