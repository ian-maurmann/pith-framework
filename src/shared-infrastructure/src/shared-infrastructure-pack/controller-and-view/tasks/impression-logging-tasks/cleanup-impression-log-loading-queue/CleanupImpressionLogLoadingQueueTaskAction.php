<?php

/**
 * Cleanup Impression Log Loading Queue Task Action
 * ------------------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4, not PSR-0.
 */

declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks;

use Pith\Workflow\PithAction;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;
use Pith\Framework\SharedInfrastructure\Model\ImpressionSystem\ImpressionService;

/**
 * Class CleanupImpressionLogLoadingQueueTaskAction
 * @package Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks
 */
class CleanupImpressionLogLoadingQueueTaskAction extends PithAction
{
    private PithAppRetriever  $app_retriever;
    private ImpressionService $impression_service;

    public function __construct(PithAppRetriever $app_retriever, ImpressionService $impression_service)
    {
        // Set object dependencies
        $this->app_retriever      = $app_retriever;
        $this->impression_service = $impression_service;
    }

    /**
     * @throws PithException
     */
    public function runAction()
    {
        // Get app
        $app = $this->app_retriever->getApp();

        // Get CLI format
        $format = $app->cli_format;

        // Header
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┏━────────────────────────────────────────────────────────────────────━┓' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┃  Impression Logging - Task 4 - Cleanup Impression Log Loading Queue  ┃' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┗━────────────────────────────────────────────────────────────────────━┛' . $format->reset);
        $app->cli_writer->writeLine(' ');

        $app->cli_writer->writeLine($format->fg_dark_yellow . 'Delete items in the queue that are no longer needed.' . $format->reset);
        $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Deleting...');

        $number_of_rows_deleted = $this->impression_service->clearItemsFromTheImpressionLogLoadingQueueThatAreNoLongerNeeded();

        $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Number of queue items deleted: ' . $format->fg_dark_cyan . $number_of_rows_deleted . $format->reset);
    }

}