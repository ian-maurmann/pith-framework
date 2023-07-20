<?php

/**
 * Import Impression Log To Database Job Route
 * -------------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4, not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Jobs\ImpressionLoggingJobs;

use Pith\Framework\PithRoute;

/**
 * Class ImportImpressionLogToDatabaseJobRoute
 * @package Pith\Framework\SharedInfrastructure\Jobs\ImpressionLoggingJobs
 */
class ImportImpressionLogToDatabaseJobRoute extends PithRoute
{
    public string $route_type   = 'job';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'world';
}
