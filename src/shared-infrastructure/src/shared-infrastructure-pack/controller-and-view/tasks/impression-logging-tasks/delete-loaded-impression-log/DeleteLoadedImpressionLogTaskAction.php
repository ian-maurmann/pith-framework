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

use Pith\Workflow\PithAction;
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
        $continue            = true;
        $does_log_file_exist = null;
        $log_file_name       = null;
        $in_queue_id         = 0;

        // Get app
        $app = $this->app_retriever->getApp();

        // Get CLI format
        $format = $app->cli_format;

        // Header
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┏━────────────────────────────────────────────────────────────━┓' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┃  Impression Logging - Task 3 - Delete loaded impression log  ┃' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┗━────────────────────────────────────────────────────────────━┛' . $format->reset);
        $app->cli_writer->writeLine(' ');

        // "Find the next item in the queue that is marked as done loading"
        if($continue) {
            $app->cli_writer->writeLine($format->fg_dark_yellow . 'Find the next item in the queue that is marked as done loading.' . $format->reset);
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Searching...');

            // Find row
            $queue_row = $this->impression_service->getNextQueuedImpressionLogMarkedAsLoadedButNotDeletedYet();
            $did_find_queue_row = (bool)count($queue_row);

            if ($did_find_queue_row) {
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Found queue item with loaded log? ' . $format->fg_bright_green . 'yes' . $format->reset);
            } else {
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Found queue item with loaded log? ' . $format->fg_bright_red . 'no' . $format->reset);
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Stopping.');
                $continue = false;
            }
        }

        // "Look at the queue item's info"
        if($continue){
            $app->cli_writer->writeLine($format->fg_dark_yellow . 'Look at the queue item\'s info:' . $format->reset);

            $in_queue_id           = $queue_row['in_queue_id'];
            $log_file_name         = $queue_row['log_file_name'];
            $datetime_done_loading = $queue_row['datetime_done_loading'];

            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'In-queue ID: ' . $format->fg_dark_cyan . $in_queue_id . $format->reset);
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Log file name: ' . $format->fg_dark_cyan . $log_file_name . $format->reset);
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Done loading at: ' . $format->fg_dark_cyan . $datetime_done_loading . $format->reset);
        }

        // "Check if log file exists"
        if($continue){
            $app->cli_writer->writeLine($format->fg_dark_yellow . 'Check if log file exists.' . $format->reset);

            $does_log_file_exist = file_exists($log_file_name);

            if($does_log_file_exist){
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'log file exists? ' . $format->fg_bright_green . 'yes' . $format->reset);
            }
            else{
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'log file exists? ' . $format->fg_bright_red . 'no' . $format->reset);
            }
        }

        // "Delete the log file"
        if($continue && $does_log_file_exist){
            $app->cli_writer->writeLine($format->fg_dark_yellow . 'Delete the log file.' . $format->reset);
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Deleting log file...');

            // Delete file
            unlink($log_file_name);
        }

        // "Re-check if log file exists"
        if($continue){
            $app->cli_writer->writeLine($format->fg_dark_yellow . 'Re-check if log file exists.' . $format->reset);

            $does_log_file_exist = file_exists($log_file_name);

            if($does_log_file_exist){
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'log file exists? ' . $format->fg_bright_red . 'yes' . $format->reset);
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Stopping.');
            }
            else{
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'log file exists? ' . $format->fg_bright_green . 'no' . $format->reset);
            }
        }

        // "Mark that the log file was deleted"
        if($continue&& !$does_log_file_exist) {
            $app->cli_writer->writeLine($format->fg_dark_yellow . 'Mark that the log file was deleted.' . $format->reset);

            $did_mark_that_the_log_file_was_deleted = $this->impression_service->markQueuedImpressionLogFileAsDeletedAfterLoading((int) $in_queue_id);
            if ($did_mark_that_the_log_file_was_deleted) {
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Did update the queue item to mark that the log file was deleted? ' . $format->fg_bright_green . 'yes' . $format->reset);
            } else {
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Did update the queue item to mark that the log file was deleted? ' . $format->fg_bright_red . 'Failed to update' . $format->reset);
            }
        }

    }

}