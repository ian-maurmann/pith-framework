<?php
# ===================================================================
# Copyright (c) 2008-2024 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

/**
 * Pith Task Logger
 * ----------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names is ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Internal;


use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;

/**
 * Class PithTaskLogger
 * @package Pith\Framework\Internal
 */
class PithTaskLogger
{
    private PithAppRetriever $app_retriever;

    public function __construct(PithAppRetriever $app_retriever)
    {
        // Set object dependencies
        $this->app_retriever = $app_retriever;
    }


    /**
     * @param $expression_string
     * @return string
     * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
     */
    public function escapeLogDelimiters($expression_string): string
    {
        $expression_string = str_replace('➤', '%➤%', $expression_string);
        $expression_string = str_replace('●', '%●%', $expression_string);

        return $expression_string;
    }

    /**
     * @param $expression_string
     * @return string
     * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
     */
    public function unescapeLogDelimiters($expression_string): string
    {
        $expression_string = str_replace('%➤%', '➤', $expression_string);
        $expression_string = str_replace('%●%', '●', $expression_string);

        return $expression_string;
    }

    public function logTask(string $task_workspace_name, string $task_name)
    {
        // Get the app
        $app = $this->app_retriever->getApp();

        // Time
        $time               = $app->clock->getLaunchMomentTimestamp();
        $hour_time          = $app->clock->getLaunchMomentHourTimestamp();
        $message_date       = date('Y-m-d H:i:s', $time);
        $filename_date_day  = date('Y-m-d', $hour_time);
        $filename_date_time = date('H-i', $hour_time);

        // Filename
        // $filename = PITH_TASK_LOG_LOCATION.'task_log_'.$filename_date_day.'_at_'.$filename_date_time.'.log';
        $filename = PITH_TASK_LOG_LOCATION.'task_log_'.$filename_date_day.'.log';


        // Build the log message
        $message = "$message_date ● $task_workspace_name ● $task_name";

        // Write to the log
        $bytes_written = file_put_contents($filename, $message . PHP_EOL , FILE_APPEND | LOCK_EX);
    }

    public function logTaskOutput(string $task_cli_output)
    {
        // Get the app
        $app = $this->app_retriever->getApp();

        // Time
        $time              = $app->clock->getLaunchMomentTimestamp();
        $message_date      = date('Y-m-d H:i:s', $time);
        $filename_date_day = date('Y-m-d', $time);

        // Filename
        $filename = PITH_TASK_OUTPUT_LOG_LOCATION.'task_output_'.$filename_date_day.'.log';

        // Build the log message
        $message = "$message_date\n";
        $message .= "▶\n";
        $message .= "$task_cli_output\n";
        $message .= "◼\n";

        // Write to the log
        $bytes_written = file_put_contents($filename, $message . PHP_EOL , FILE_APPEND | LOCK_EX);
    }
}