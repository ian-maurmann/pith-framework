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

use Pith\Workflow\PithAction;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\SharedInfrastructure\Model\ImpressionSystem\ImpressionService;
use Pith\Framework\SharedInfrastructure\Model\UserSystem\UserService;

/**
 * Class QueueImpressionLogsForImportTaskAction
 * @package Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks
 */
class QueueImpressionLogsForImportTaskAction extends PithAction
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
     * @throws \Pith\Framework\PithException
     */
    public function runAction()
    {
        // Get app
        $app = $this->app_retriever->getApp();

        // Get CLI format
        $format = $app->cli_format;

        // Header
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┏━────────────────────────────────────────────────────────────────━┓' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┃  Impression Logging - Task 1 - Queue impression logs for import  ┃' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┗━────────────────────────────────────────────────────────────────━┛' . $format->reset);
        $app->cli_writer->writeLine('    ');

        // Folder
        $folder = PITH_IMPRESSION_LOG_LOCATION;
        $app->cli_writer->writeLine($format->fg_dark_yellow . 'Searching for impression logs in folder:' . $format->reset);
        $app->cli_writer->writeLine($folder);
        $app->cli_writer->writeLine('    ');

        // Get all logs
        $files = glob($folder . '*.log');
        $file_count = count($files);
        //$app->cli_writer->writeLine(print_r($files, true));
        //$app->cli_writer->writeLine('    ');
        $app->cli_writer->writeLine($format->fg_dark_yellow . 'Found ' . (string) $file_count . ' impression log files:' . $format->reset);
        foreach($files as $file_index => $file){
            $file_number = $file_index + 1;
            $app->cli_writer->writeLine('    ' . $format->fg_dark_yellow . (string) $file_number . $format->reset . '    ' . $file);
        }
        $app->cli_writer->writeLine('    ');

        // Add to queue
        $app->cli_writer->writeLine($format->fg_dark_yellow . 'Add impression log files to import queue:' . $format->reset);
        foreach($files as $file_index => $file){
            $file_number = $file_index + 1;
            $change_time = filectime($file);
            $change_date_string_1 = date("F d Y", $change_time);
            $change_date_string_2 = date("H:i:s", $change_time);
            $time_now = time();
            $seconds_diff = $time_now - $change_time;
            $age_string = $this->secondsToTime($seconds_diff);
            $is_over_2_hours_old = $seconds_diff > 7200;
            $is_over_2_hours_old_yn_colored = $is_over_2_hours_old ? $format->fg_bright_green . 'yes' : $format->fg_bright_yellow . 'no';
            $app->cli_writer->writeLine('    ' . $format->fg_dark_yellow . (string) $file_number . $format->reset . '    ' . $file);
            $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '↳ - '. $format->reset . 'impression log');
            $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '  - '. $format->reset . 'Last updated timestamp: ' . $format->fg_dark_cyan . $change_time . $format->reset);
            $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '  - '. $format->reset . $change_date_string_1 . ' at ' . $change_date_string_2);
            $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '  - '. $format->reset . 'Diff seconds to now: ' . $format->fg_dark_cyan . $seconds_diff . $format->reset);
            $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '  - '. $format->reset . 'Age: ' . $age_string);
            $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '  - '. $format->reset . 'Is over 2 hours old? ' . $is_over_2_hours_old_yn_colored . $format->reset);

            if($is_over_2_hours_old){
                $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '  - '. $format->reset . 'Checking if file is already queued for import.... ');

                $is_file_queued_for_import = $this->impression_service->isImpressionLogFileQueuedForImport($file);
                $is_file_queued_for_import_yn_colored = $is_file_queued_for_import ? $format->fg_bright_yellow . 'yes' : $format->fg_bright_green . 'no';

                $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '  - '. $format->reset . 'Is already queued for import? ' . $is_file_queued_for_import_yn_colored . $format->reset);

                if($is_file_queued_for_import){
                    $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '  - '. $format->reset . 'Ignore for now.');
                }
                else{
                    $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '  - '. $format->reset . 'Adding to queue for import.... ');
                    $queue_id = $this->impression_service->addImpressionLogFileToQueueForImport($file);
                    $did_add_to_queue_for_import = $queue_id > 0;
                    $did_add_to_queue_for_import_yn_colored = $did_add_to_queue_for_import ? $format->fg_bright_green . 'yes' : $format->fg_bright_red . 'no';
                    $queue_id_colored = $did_add_to_queue_for_import ? $format->fg_bright_green . (string) $queue_id : $format->fg_bright_red . (string) $queue_id;

                    $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '  - '. $format->reset . 'Added to queue? ' . $did_add_to_queue_for_import_yn_colored . $format->reset);
                    $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '  - '. $format->reset . 'ID in queue: ' . $queue_id_colored . $format->reset);
                }
            }
            else{
                $app->cli_writer->writeLine('            ' . $format->fg_dark_yellow .  '  - '. $format->reset . 'Ignore for now.');
            }

            $app->cli_writer->writeLine('    ');

            if($file_number > 49){
                $app->cli_writer->writeLine($format->fg_dark_yellow . 'Stopping at ' . (string) $file_number . ' to not stress the memory.' . $format->reset);
                break;
            }
        }
        $app->cli_writer->writeLine('    ');
    }

    private function secondsToTime($inputSeconds): string
    {

        //See:
        //    https://stackoverflow.com/questions/8273804/convert-seconds-into-days-hours-minutes-and-seconds
        //    Answer by Luke Cousins

        if($inputSeconds > 0){
            $secondsInAMinute = 60;
            $secondsInAnHour = 60 * $secondsInAMinute;
            $secondsInADay = 24 * $secondsInAnHour;

            // Extract days
            $days = floor($inputSeconds / $secondsInADay);

            // Extract hours
            $hourSeconds = $inputSeconds % $secondsInADay;
            $hours = floor($hourSeconds / $secondsInAnHour);

            // Extract minutes
            $minuteSeconds = $hourSeconds % $secondsInAnHour;
            $minutes = floor($minuteSeconds / $secondsInAMinute);

            // Extract the remaining seconds
            $remainingSeconds = $minuteSeconds % $secondsInAMinute;
            $seconds = ceil($remainingSeconds);

            // Format and return
            $timeParts = [];
            $sections = [
                'day' => (int)$days,
                'hour' => (int)$hours,
                'minute' => (int)$minutes,
                'second' => (int)$seconds,
            ];

            foreach ($sections as $name => $value){
                if ($value > 0){
                    $timeParts[] = $value. ' '.$name.($value == 1 ? '' : 's');
                }
            }

            return implode(', ', $timeParts);
        }
        else{
            return 'now';
        }
    }
}