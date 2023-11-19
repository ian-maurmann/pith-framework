<?php

/**
 * Impression Logging Task Workspace
 * ---------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection   - Using PSR-4, not PSR-0.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Tasks;


/**
 * Class ImpressionLoggingTaskWorkspace
 * @package Pith\Framework\SharedInfrastructure\Tasks
 */
class ImpressionLoggingTaskWorkspace
{
    public array $tasks = [
        ['task', 'cleanup_impression_log_loading_queue', '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\CleanupImpressionLogLoadingQueueTaskRoute'],
        ['task', 'delete_loaded_impression_log',         '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\DeleteLoadedImpressionLogTaskRoute'],
        ['task', 'gather_unique_daily_views',            '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\GatherUniqueDailyViewsTaskRoute'],
        ['task', 'hello_world',                          '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\HelloWorldTaskRoute'],
        ['task', 'import_impression_log_to_database',    '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\ImportImpressionLogToDatabaseTaskRoute'],
        ['task', 'lorem_ipsum',                          '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\LoremIpsumTaskRoute'],
        ['task', 'queue_impression_logs_for_import',     '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\QueueImpressionLogsForImportTaskRoute'],
    ];
}