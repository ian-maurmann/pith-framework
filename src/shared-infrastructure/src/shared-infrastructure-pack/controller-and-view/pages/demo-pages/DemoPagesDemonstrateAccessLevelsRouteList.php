<?php

/**
 * Demo-Pages: Demonstrate Access-Levels Route-List
 * ------------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection   - Using PSR-4.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRouteList;

/**
 * Class DemoPagesDemonstrateAccessLevelsRouteList
 * @package Pith\Framework\SharedInfrastructure
 */
class DemoPagesDemonstrateAccessLevelsRouteList extends PithRouteList
{
    public array $routes = [
        ['route', 'GET', '',             '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateAccessLevelsRoute'],
        ['route', 'GET', '/user-access', '\\Pith\\Framework\\SharedInfrastructure\\UserAccessRoute'],
    ];
}