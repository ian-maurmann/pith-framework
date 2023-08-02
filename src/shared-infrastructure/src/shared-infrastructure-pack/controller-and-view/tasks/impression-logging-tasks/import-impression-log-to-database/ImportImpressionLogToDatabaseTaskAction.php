<?php

/**
 * Import Impression Log To Database Task Action
 * ---------------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4, not PSR-0.
 */

declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks;

use Pith\Framework\Internal\PithUnitConversionUtility;
use Pith\Framework\PithAction;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;
use Pith\Framework\SharedInfrastructure\Model\ImpressionSystem\ImpressionService;

/**
 * Class ImportImpressionLogToDatabaseTaskAction
 * @package Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks
 */
class ImportImpressionLogToDatabaseTaskAction extends PithAction
{
    private PithAppRetriever          $app_retriever;
    private ImpressionService         $impression_service;
    private PithUnitConversionUtility $unit_conversion_utility;

    public function __construct(PithAppRetriever $app_retriever, ImpressionService $impression_service, PithUnitConversionUtility $unit_conversion_utility)
    {
        // Set object dependencies
        $this->app_retriever           = $app_retriever;
        $this->impression_service      = $impression_service;
        $this->unit_conversion_utility = $unit_conversion_utility;
    }

    /**
     * @throws PithException
     */
    public function runAction()
    {
        $continue = true;

        // Get app
        $app = $this->app_retriever->getApp();

        // Get CLI format
        $format = $app->cli_format;

        // Header
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┏━─────────────────────────────────────────────────────────────────━┓' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┃  Impression Logging - Task 2 - Import impression log to database  ┃' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┗━─────────────────────────────────────────────────────────────────━┛' . $format->reset);
        $app->cli_writer->writeLine(' ');

        $app->cli_writer->writeLine($format->fg_dark_yellow . 'Looking for next item in queue:' . $format->reset);
        $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Selecting...');

        // Find row
        $queue_row = $this->impression_service->getOldestQueuedImpressionLog();
        $did_find_queued_row = (bool) count($queue_row);

        if($did_find_queued_row){
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Found the oldest item in the queue? ' . $format->fg_bright_green . 'yes' . $format->reset);
        }
        else{
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Found the oldest item in the queue? ' . $format->fg_bright_red . 'no' . $format->reset);
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Stopping.');
            $continue = false;
        }

        // Get row variables
        $in_queue_id                 = $queue_row['in_queue_id'] ?? 0;
        $log_file_name               = $queue_row['log_file_name'] ?? '';
        $datetime_added_to_queue     = $queue_row['datetime_added_to_queue'] ?? '';
        $datetime_start_loading      = $queue_row['datetime_start_loading'] ?? '';
        $datetime_done_loading       = $queue_row['datetime_done_loading'] ?? '';
        $datetime_file_not_found     = $queue_row['datetime_file_not_found'] ?? '';
        $has_datetime_start_loading  = !empty($datetime_start_loading);
        $has_datetime_done_loading   = !empty($datetime_done_loading);
        $has_datetime_file_not_found = !empty($datetime_file_not_found);

        // Display row variables
        $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'In-queue ID: ' . $format->fg_dark_cyan . $in_queue_id . $format->reset);
        $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Log file: ' . $format->fg_dark_cyan . $log_file_name . $format->reset);
        $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Added to queue on: ' . $format->fg_dark_cyan . $datetime_added_to_queue . $format->reset);

        // Is marked as file not found?
        if($continue){
            if($has_datetime_file_not_found){
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Is marked as file not found? ' . $format->fg_bright_red . 'yes' . $format->reset);
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Stopping.');
                $continue = false;
            }
            else{
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Is marked as file not found? ' . $format->fg_bright_green . 'no' . $format->reset);
            }
        }

        // Is marked as already done loading?
        if($continue){
            if($has_datetime_done_loading){
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Is marked as already done loading? ' . $format->fg_bright_red . 'yes' . $format->reset);
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Stopping.');
                $continue = false;
            }
            else{
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Is marked as already done loading? ' . $format->fg_bright_green . 'no' . $format->reset);
            }
        }

        // Is marked as already done loading?
        if($continue){
            if($has_datetime_start_loading){
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Is marked as already started loading? ' . $format->fg_bright_red . 'yes' . $format->reset);
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Stopping.');
                $continue = false;
            }
            else{
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Is marked as already started loading? ' . $format->fg_bright_green . 'no' . $format->reset);
            }
        }

        // Does file exist?
        if($continue){
            $log_file_exists = file_exists((string) $log_file_name);
            if($log_file_exists){
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Does file exist? ' . $format->fg_bright_green . 'yes' . $format->reset);
            }
            else{
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Does file exist? ' . $format->fg_bright_red . 'no' . $format->reset);
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- Mark file as not found' . $format->reset);

                $did_mark_as_not_found = $this->impression_service->markQueuedImpressionLogFileAsNotFound((int) $in_queue_id);

                if($did_mark_as_not_found){
                    $app->cli_writer->writeLine('      ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Did mark as not found? ' . $format->fg_bright_green . 'yes' . $format->reset);
                }
                else{
                    $app->cli_writer->writeLine('      ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Did mark as not found? ' . $format->fg_bright_red . 'Failed to update' . $format->reset);
                }

                $app->cli_writer->writeLine('      ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Stopping.');
                $continue = false;
            }
        }

        if($continue){
            $file_size_in_bytes = filesize($log_file_name);
            $file_size_readable_string = $this->unit_conversion_utility->getHumanFilesize($file_size_in_bytes);
            
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Log file size in bytes: ' . $format->fg_dark_cyan . $file_size_in_bytes . $format->reset);
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Log file size: ' . $format->fg_dark_cyan . $file_size_readable_string . $format->reset);
        }

    }

}