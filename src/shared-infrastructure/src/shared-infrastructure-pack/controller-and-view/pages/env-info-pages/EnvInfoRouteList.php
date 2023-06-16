<?php

/**
 * Env-Info Route List
 * -------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages;

use Pith\Framework\PithRouteList;

/**
 * Class EnvInfoRouteList
 * @package Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages
 */
class EnvInfoRouteList extends PithRouteList
{
    public array $routes = [
        ['route', 'GET', '',                  '\\Pith\\Framework\\SharedInfrastructure\\Pages\\EnvInfoPages\\EnvInfoRoute'],
        ['route', 'GET', '/database-info',    '\\Pith\\Framework\\SharedInfrastructure\\Pages\\EnvInfoPages\\EnvInfoDatabaseInfoRoute'],
        ['route', 'GET', '/fixed-path-links', '\\Pith\\Framework\\SharedInfrastructure\\Pages\\EnvInfoPages\\EnvInfoFixedPathFileLinksRoute'],
        ['route', 'GET', '/php-info',         '\\Pith\\Framework\\SharedInfrastructure\\Pages\\EnvInfoPages\\EnvInfoPhpInfoRoute'],
        ['route', 'GET', '/route-list',       '\\Pith\\Framework\\SharedInfrastructure\\Pages\\EnvInfoPages\\EnvInfoRouteListRoute'],
        ['route', 'GET', '/server-info',      '\\Pith\\Framework\\SharedInfrastructure\\Pages\\EnvInfoPages\\EnvInfoServerInfoRoute'],
    ];
}