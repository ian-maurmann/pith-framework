<?php

/**
 * Queue Impression Logs For Import task action
 * -------------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4, not PSR-0.
 */

declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks;

use Pith\Framework\PithAction;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\SharedInfrastructure\Model\UserSystem\UserService;

/**
 * Class QueueImpressionLogsForImportTaskAction
 * @package Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks
 */
class QueueImpressionLogsForImportTaskAction extends PithAction
{
    private PithAppRetriever $app_retriever;

    public function __construct(PithAppRetriever $app_retriever)
    {
        // Set object dependencies
        $this->app_retriever = $app_retriever;
    }

    public function runAction()
    {
        // Get app
        $app = $this->app_retriever->getApp();
        $format = $app->cli_format;

        // Header
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┏━────────────────────────────────────────────────────────────────━┓' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┃  Impression Logging - Task 1 - Queue impression logs for import  ┃' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┗━────────────────────────────────────────────────────────────────━┛' . $format->reset);


        $app->cli_writer->writeLine('___ Queue Impression Log For Import task action ___');
    }

}