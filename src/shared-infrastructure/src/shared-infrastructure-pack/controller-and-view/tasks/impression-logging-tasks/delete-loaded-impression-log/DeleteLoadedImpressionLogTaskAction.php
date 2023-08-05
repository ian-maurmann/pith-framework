<?php

/**
 * Delete Loaded Impression Log Task Action
 * -----------------------------------------
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
use Pith\Framework\PithException;
use Pith\Framework\SharedInfrastructure\Model\ImpressionSystem\ImpressionService;

/**
 * Class DeleteLoadedImpressionLogTaskAction
 * @package Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks
 */
class DeleteLoadedImpressionLogTaskAction extends PithAction
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
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┏━────────────────────────────────────────────────────────────━┓' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┃  Impression Logging - Task 3 - Delete loaded impression log  ┃' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┗━────────────────────────────────────────────────────────────━┛' . $format->reset);
        $app->cli_writer->writeLine(' ');

        $app->cli_writer->writeLine($format->fg_dark_yellow . 'Find the next item in the queue that is marked as done loading.' . $format->reset);
        $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Searching...');

        // Find row
        $queue_row = $this->impression_service->getNextQueuedImpressionLogMarkedAsLoadedButNotDeletedYet();
        $did_find_queue_row = (bool) count($queue_row);

        if($did_find_queue_row){
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Found queue item for loaded log? ' . $format->fg_bright_green . 'yes' . $format->reset);
        }
        else{
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Found queue item for loaded log? ' . $format->fg_bright_red . 'no' . $format->reset);
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Stopping.');
            $continue = false;
        }
    }

}