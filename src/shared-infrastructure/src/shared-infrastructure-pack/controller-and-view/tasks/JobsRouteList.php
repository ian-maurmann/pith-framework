<?php

/**
 * Jobs Route List
 * ---------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection   - Using PSR-4, not PSR-0.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Jobs;

use Pith\Framework\PithRouteList;

/**
 * Class JobsRouteList
 * @package Pith\Framework\SharedInfrastructure\Jobs
 */
class JobsRouteList extends PithRouteList
{
    public array $routes = [
        ['route', ['GET'], '/import_impression_log_to_database', '\\Pith\\Framework\\SharedInfrastructure\\Jobs\\ImpressionLoggingJobs\\ImportImpressionLogToDatabaseJobRoute'],
    ];
}