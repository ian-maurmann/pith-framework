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
        ['GET', '/',                                                '\\Pith\\Framework\\SharedInfrastructure\\HomeRoute'],
        ['GET', '/error-404',                                       '\\Pith\\Framework\\SharedInfrastructure\\Error404Route'],
        ['GET', '/lorem-ipsum',                                     '\\Pith\\Framework\\SharedInfrastructure\\LoremIpsumRoute'],
        ['GET', '/resources/framework/shared-ui/{filepath:.+}',     '\\Pith\\Framework\\SharedUiResourcePack\\SharedUiApplicationResourceRoute'],
        ['GET', '/resources/vendor/common-libraries/{filepath:.+}', '\\Pith\\Framework\\CommonLibrariesResourcePack\\CommonLibrariesResourceRoute'],
        ['GET', '/show-library/font-awesome',                       '\\Pith\\Framework\\SharedInfrastructure\\VerifyFontAwesomeRoute'],
        ['GET', '/show-library/font-awesome-compatibility',         '\\Pith\\Framework\\SharedInfrastructure\\VerifyFontAwesomeCompatibilityForkRoute'],
    ];
}