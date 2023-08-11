<?php

/**
 * Queue Impression Logs For Import task route
 * ------------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4, not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks;

use Pith\Framework\PithRoute;

/**
 * Class QueueImpressionLogsForImportTaskRoute
 * @package Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks
 */
class QueueImpressionLogsForImportTaskRoute extends PithRoute
{
    public string $route_type   = 'task';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'cron-ip';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\QueueImpressionLogsForImportTaskAction';
    public string $view_adapter = '\\Pith\\CliViewAdapter\\PithCliViewAdapter';
}
