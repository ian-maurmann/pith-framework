<?php

/**
 * Delete Loaded Impression Log Task Route
 * ---------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4, not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks;

use Pith\Workflow\PithRoute;

/**
 * Class DeleteLoadedImpressionLogTaskRoute
 * @package Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks
 */
class DeleteLoadedImpressionLogTaskRoute extends PithRoute
{
    public string $route_type   = 'task';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'task';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\DeleteLoadedImpressionLogTaskAction';
    public string $view_adapter = '\\Pith\\CliViewAdapter\\PithCliViewAdapter';
}
