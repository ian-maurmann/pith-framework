<?php

/**
 * Cleanup Impression Log Loading Queue Task Route
 * -----------------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4, not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks;

use Pith\Framework\PithRoute;

/**
 * Class CleanupImpressionLogLoadingQueueTaskRoute
 * @package Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks
 */
class CleanupImpressionLogLoadingQueueTaskRoute extends PithRoute
{
    public string $route_type   = 'job';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\CleanupImpressionLogLoadingQueueTaskAction';
    public string $view_adapter = '\\Pith\\CliViewAdapter\\PithCliViewAdapter';
}