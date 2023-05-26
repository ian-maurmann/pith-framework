<?php

/**
 * Env-Info Route List
 * -------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRouteList;

/**
 * Class EnvInfoRouteList
 * @package Pith\Framework\SharedInfrastructure
 */
class EnvInfoRouteList extends PithRouteList
{
    public array $routes = [
        ['route', 'GET', '',                  '\\Pith\\Framework\\SharedInfrastructure\\EnvInfoRoute'],
        ['route', 'GET', '/database-info',    '\\Pith\\Framework\\SharedInfrastructure\\EnvInfoDatabaseInfoRoute'],
        ['route', 'GET', '/fixed-path-links', '\\Pith\\Framework\\SharedInfrastructure\\EnvInfoFixedPathFileLinksRoute'],
        ['route', 'GET', '/php-info',         '\\Pith\\Framework\\SharedInfrastructure\\EnvInfoPhpInfoRoute'],
        ['route', 'GET', '/route-list',       '\\Pith\\Framework\\SharedInfrastructure\\EnvInfoRouteListRoute'],
        ['route', 'GET', '/server-info',      '\\Pith\\Framework\\SharedInfrastructure\\EnvInfoServerInfoRoute'],
    ];
}