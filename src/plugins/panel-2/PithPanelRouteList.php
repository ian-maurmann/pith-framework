<?php

/**
 * Pith Panel Route List
 * ---------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel;

use Pith\Workflow\PithRouteList;

/**
 * Class PithPanelRouteList
 * @package Pith\Framework\Panel
 */
class PithPanelRouteList extends PithRouteList
{
    public array $routes = [
        ['route', 'GET', '',                         '\\Pith\\Framework\\Panel\\Pages\\HomeRoute'],
        ['route', 'GET', '/tasks',                   '\\Pith\\Framework\\Panel\\Pages\\TasksRoute'],
        ['route', 'GET', '/lorem-ipsum',             '\\Pith\\Framework\\Panel\\Pages\\LoremIpsumRoute'],
        ['route', 'GET', '/resources/{filepath:.+}', '\\Pith\\Framework\\Panel\\Theme\\ThemeResourcesRoute'],
    ];
}