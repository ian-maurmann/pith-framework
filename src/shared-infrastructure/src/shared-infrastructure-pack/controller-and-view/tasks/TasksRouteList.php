<?php

/**
 * Tasks Route List
 * ----------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection   - Using PSR-4, not PSR-0.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Tasks;

use Pith\Framework\PithRouteList;

/**
 * Class TasksRouteList
 * @package Pith\Framework\SharedInfrastructure\Tasks
 */
class TasksRouteList extends PithRouteList
{
    public array $routes = [
        ['route', ['GET'], '/hello_world',                       '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\HelloWorldTaskRoute'],
        ['route', ['GET'], '/delete-loaded-impression-logs',     '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\DeleteLoadedImpressionLogTaskRoute'],
        ['route', ['GET'], '/import_impression_log_to_database', '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\ImportImpressionLogToDatabaseTaskRoute'],
        ['route', ['GET'], '/lorem_ipsum',                       '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\LoremIpsumTaskRoute'],
        ['route', ['GET'], '/queue_impression_logs_for_import',  '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\QueueImpressionLogsForImportTaskRoute'],
    ];
}