<?php

/**
 * Import Impression Log To Database Task Route
 * --------------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4, not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks;

use Pith\Framework\PithRoute;

/**
 * Class ImportImpressionLogToDatabaseTaskRoute
 * @package Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks
 */
class ImportImpressionLogToDatabaseTaskRoute extends PithRoute
{
    public string $route_type   = 'task';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'cron-ip';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTasks\\ImportImpressionLogToDatabaseTaskAction';
    public string $view_adapter = '\\Pith\\CliViewAdapter\\PithCliViewAdapter';
}
