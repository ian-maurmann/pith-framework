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
use Pith\Workflow\PithAction;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;
use Pith\Framework\SharedInfrastructure\Model\ImpressionSystem\ImpressionService;
use SplFileObject;

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
        $queue_row = $this->impression_service->getNextQueuedImpressionLogToImport();
        $did_find_queued_row = (bool) count($queue_row);

        if($did_find_queued_row){
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Found the oldest item in the queue? ' . $format->fg_bright_green . 'yes' . $format->reset);
        }
        else{
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Found the oldest item in the queue? ' . $format->fg_bright_red . 'no' . $format->reset);
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Stopping.');
            $continue = false;
        }

        if($continue) {
            // Get row variables
            $in_queue_id = $queue_row['in_queue_id'] ?? 0;
            $log_file_name = $queue_row['log_file_name'] ?? '';
            $datetime_added_to_queue = $queue_row['datetime_added_to_queue'] ?? '';
            $datetime_start_loading = $queue_row['datetime_start_loading'] ?? '';
            $datetime_done_loading = $queue_row['datetime_done_loading'] ?? '';
            $datetime_file_not_found = $queue_row['datetime_file_not_found'] ?? '';
            $has_datetime_start_loading = !empty($datetime_start_loading);
            $has_datetime_done_loading = !empty($datetime_done_loading);
            $has_datetime_file_not_found = !empty($datetime_file_not_found);

            // Display row variables
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'In-queue ID: ' . $format->fg_dark_cyan . $in_queue_id . $format->reset);
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Log file: ' . $format->fg_dark_cyan . $log_file_name . $format->reset);
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Added to queue on: ' . $format->fg_dark_cyan . $datetime_added_to_queue . $format->reset);
        }

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

        if($continue){
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow .  '- Read log file' . $format->reset);

            $file = new SplFileObject($log_file_name);

            $did_mark_as_started_loading = $this->impression_service->markQueuedImpressionLogFileAsStartedLoading((int) $in_queue_id);
            if($did_mark_as_started_loading){
                $app->cli_writer->writeLine('      ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Did mark as started loading? ' . $format->fg_bright_green . 'yes' . $format->reset);
            }
            else{
                $app->cli_writer->writeLine('      ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Did mark as started loading? ' . $format->fg_bright_red . 'Failed to update' . $format->reset);
                $continue = false;
            }

            if($continue) {
                $line_number = 0;
                while ($continue && !$file->eof()) {
                    $line_number++;
                    $line = $file->fgets();
                    $line_length = mb_strlen($line);

                    $app->cli_writer->writeLine('      ' . $format->fg_dark_yellow . '- Line ' . $line_number . $format->reset);
                    $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Line Length: ' . $format->fg_dark_cyan . $line_length . $format->reset);

                    if ($line_length > 1) {
                        $impression_variables = explode(' ● ', $line);
                        $impression_datetime = $impression_variables[0];
                        $impression_http_method = $impression_variables[1];
                        $impression_uri = $impression_variables[2];
                        $impression_port = $impression_variables[3];
                        $impression_access_level = $impression_variables[4];
                        $impression_allowed_or_denied = $impression_variables[5];
                        $impression_remote_ip_address = $impression_variables[6];
                        $impression_session_id = $impression_variables[7];
                        $impression_user_or_guest = $impression_variables[8];
                        $impression_user_id_string = $impression_variables[9];
                        $impression_user_agent_string = $impression_variables[10];
                        $ch_ua = $impression_variables[11];
                        $ch_ua_platform = $impression_variables[12];
                        $ch_ua_platform_version = $impression_variables[13];
                        $ch_ua_mobile = $impression_variables[14];
                        $ch_ua_model = $impression_variables[15];
                        $ch_ua_architecture = $impression_variables[16];
                        $ch_ua_bitness = $impression_variables[17];
                        $client_accept_language_string = $impression_variables[18];
                        $referer_string = $impression_variables[19];
                        $ch_downlink = $impression_variables[20];
                        $ch_viewport_width = $impression_variables[21];
                        $ch_prefers_color_scheme = $impression_variables[22];

                        $impression_port_as_int          = (int) $impression_port;
                        $was_allowed_01                  = $impression_allowed_or_denied === 'allowed' ? 1 : 0;
                        $was_logged_user_01              = $impression_user_or_guest === 'user' ? 1 : 0;
                        $impression_user_id_int          = (int) $impression_user_id_string;
                        $ch_prefers_color_scheme_trimmed = trim($ch_prefers_color_scheme);
                        $ch_ua_platform_no_quote         = str_replace('"', '', $ch_ua_platform);
                        $ch_ua_platform_version_no_quote = str_replace('"', '', $ch_ua_platform_version);
                        $ch_ua_model_no_quote            = str_replace('"', '', $ch_ua_model);
                        $ch_ua_architecture_no_quote     = str_replace('"', '', $ch_ua_architecture);
                        $ch_ua_bitness_no_quote          = str_replace('"', '', $ch_ua_bitness);

                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Datetime: ' . $format->fg_dark_cyan . $impression_datetime . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'HTTP Method: ' . $format->fg_dark_cyan . $impression_http_method . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'URI: ' . $format->fg_dark_cyan . $impression_uri . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Port: ' . $format->fg_dark_cyan . $impression_port . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Access Level: ' . $format->fg_dark_cyan . $impression_access_level . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Allowed or denied? ' . $format->fg_dark_cyan . $impression_allowed_or_denied . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'IP address: ' . $format->fg_dark_cyan . $impression_remote_ip_address . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Session ID: ' . $format->fg_dark_cyan . $impression_session_id . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'User or guest? ' . $format->fg_dark_cyan . $impression_user_or_guest . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'User ID: ' . $format->fg_dark_cyan . $impression_user_id_string . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'User agent string: ' . $format->fg_dark_cyan . $impression_user_agent_string . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'CH UA: ' . $format->fg_dark_cyan . $ch_ua . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'CH UA platform: ' . $format->fg_dark_cyan . $ch_ua_platform . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'CH UA platform version: ' . $format->fg_dark_cyan . $ch_ua_platform_version . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'CH UA mobile: ' . $format->fg_dark_cyan . $ch_ua_mobile . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'CH UA model: ' . $format->fg_dark_cyan . $ch_ua_model . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'CH UA architecture: ' . $format->fg_dark_cyan . $ch_ua_architecture . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'CH UA bitness: ' . $format->fg_dark_cyan . $ch_ua_bitness . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Client accept language string: ' . $format->fg_dark_cyan . $client_accept_language_string . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Referer string: ' . $format->fg_dark_cyan . $referer_string . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'CH downlink: ' . $format->fg_dark_cyan . $ch_downlink . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'CH viewport width: ' . $format->fg_dark_cyan . $ch_viewport_width . ' ' . $format->reset);
                        $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow . '- ' . $format->reset . 'CH prefers color scheme: ' . $format->fg_dark_cyan . $ch_prefers_color_scheme_trimmed . ' ' . $format->reset);

                        // Insert impression
                        $did_insert_impression = $this->impression_service->insertImpression(
                            $impression_datetime,
                            $impression_http_method,
                            $impression_uri,
                            $impression_port_as_int,
                            $impression_access_level,
                            $was_allowed_01,
                            $impression_remote_ip_address,
                            $impression_session_id,
                            $was_logged_user_01,
                            $impression_user_id_int,
                            $impression_user_agent_string,
                            $ch_ua,
                            $ch_ua_platform_no_quote,
                            $ch_ua_platform_version_no_quote,
                            $ch_ua_mobile,
                            $ch_ua_model_no_quote,
                            $ch_ua_architecture_no_quote,
                            $ch_ua_bitness_no_quote,
                            $client_accept_language_string,
                            $referer_string,
                            $ch_downlink,
                            $ch_viewport_width,
                            $ch_prefers_color_scheme_trimmed,
                        );

                        if($did_insert_impression){
                            $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow .  '- '. $format->reset . $format->fg_bright_green . 'Saved impression to the impressions table.' . $format->reset);
                        }
                        else{
                            $app->cli_writer->writeLine('          ' . $format->fg_dark_yellow .  '- '. $format->reset . $format->fg_bright_red . 'Failed to impression to the impressions table.' . $format->reset);
                            $continue = false;
                        }
                    }

                    //$app->cli_writer->writeLine($format->fg_dark_red . $line . $format->reset);
                }
            }

            if($continue) {
                $did_mark_as_done_loading = $this->impression_service->markQueuedImpressionLogFileAsDoneLoading((int) $in_queue_id);
                if($did_mark_as_done_loading){
                    $app->cli_writer->writeLine('      ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Did mark as done loading? ' . $format->fg_bright_green . 'yes' . $format->reset);
                }
                else{
                    $app->cli_writer->writeLine('      ' . $format->fg_dark_yellow .  '- '. $format->reset . 'Did mark as done loading? ' . $format->fg_bright_red . 'Failed to update' . $format->reset);
                    $continue = false;
                }
            }
        }



    }

}