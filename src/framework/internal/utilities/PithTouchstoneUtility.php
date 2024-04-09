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
 * Pith Touchstone Utility
 * -----------------------
 *
 * @noinspection PhpUnnecessaryLocalVariableInspection - For Readability
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Internal;

use DateTime;
use Exception;
use Pith\Framework\PithException;

/**
 * Class PithTouchstoneUtility
 * @package Pith\Framework\Internal
 */
class PithTouchstoneUtility
{
//    public const TIMEFRAME_TIME_WINDOW = 1;
//    public const TIMEFRAME_TIME_ELAPSED = 2;
//
//    public const TIME_WINDOW_MINUTES = 1;
//    public const TIME_WINDOW_HOURS = 2;
//    public const TIME_WINDOW_DAYS = 3;

    private PithTimeWindowUtility $time_window_utility;

    public function __construct()
    {
        // Set objects
        $this->time_window_utility = new PithTimeWindowUtility();
    }

    // public function touch(int $timeframe_mode, int $amount, int $time_unit){}

    /**
     * @throws PithException
     */
    protected function createFileIfNotExists(string $file_path): bool
    {
        // Check if file exists yet
        $does_file_exist = file_exists($file_path);

        // Try to create file
        if(!$does_file_exist){
            $did_create_file = touch($file_path);
            if($did_create_file){
                return true;
            }
            else{
                throw new PithException(
                    'Pith Framework Exception 9001: Touchstone file could not be created',
                    9001
                );
            }
        }

        return false;
    }

    /**
     * @throws PithException
     */
    public function touchOnceIn20MinuteWindow(string $file_path): bool
    {
        // Create file if needed, throws exception if fails to create
        $did_create_new = $this->createFileIfNotExists($file_path);
        if($did_create_new){
            return true;
        }

        // Get datetime modified
        $file_modified_timestamp = filemtime($file_path);
        $file_modified_datetime = new DateTime();
        $file_modified_datetime->setTimestamp($file_modified_timestamp);

        // Get time of 20 minute window when file was modified
        $file_modified_time_window_datetime = $this->time_window_utility->get20MinuteWindowStartDatetime($file_modified_datetime);
        $file_modified_time_window_timestamp = $file_modified_time_window_datetime->getTimestamp();

        // Get time of 20 minute window now
        $datetime_now = new DateTime();
        $current_time_window_datetime = $this->time_window_utility->get20MinuteWindowStartDatetime($datetime_now);
        $current_time_window_timestamp = $current_time_window_datetime->getTimestamp();

        if($file_modified_time_window_timestamp < $current_time_window_timestamp){
            $did_touch = touch($file_path);
            if(!$did_touch){
                throw new PithException(
                    'Pith Framework Exception 9002: Touchstone file mtime could not be updated',
                    9002
                );
            }
            return true;
        }

        return false;
    }

    /**
     * @throws PithException
     * @throws Exception
     */
    public function touchOnceInTimeFrame(string $file_path, string $timeframe_mode_string): bool
    {
        $is_time_to_touch = false;

        // Create file if needed, throws exception if fails to create
        $did_create_new = $this->createFileIfNotExists($file_path);
        if($did_create_new){
            return true;
        }

        // Get datetime modified
        $file_modified_timestamp = filemtime($file_path);
        $file_modified_datetime = new DateTime();
        $file_modified_datetime->setTimestamp($file_modified_timestamp);

        $is_cool_down = str_starts_with($timeframe_mode_string, 'after');
        $is_window    = str_starts_with($timeframe_mode_string, 'window');

        if($is_window){
            // Get start of time window when file was modified
            $file_modified_time_window_datetime = $this->time_window_utility->getWindowStartDatetimeByTimeframeString($file_modified_datetime, $timeframe_mode_string);
            $file_modified_time_window_timestamp = $file_modified_time_window_datetime->getTimestamp();

            // Get start of time window now
            $datetime_now = new DateTime();
            $current_time_window_datetime = $this->time_window_utility->getWindowStartDatetimeByTimeframeString($datetime_now, $timeframe_mode_string);
            $current_time_window_timestamp = $current_time_window_datetime->getTimestamp();

            $is_time_to_touch = $file_modified_time_window_timestamp < $current_time_window_timestamp;
        }
        elseif ($is_cool_down){
            $current_timestamp = time();
            $is_time_to_touch = $this->time_window_utility->isCoolDownOver($current_timestamp, $file_modified_timestamp, $timeframe_mode_string);
        }

        if($is_time_to_touch){
            $did_touch = touch($file_path);
            if(!$did_touch){
                throw new PithException(
                    'Pith Framework Exception 9002: Touchstone file mtime could not be updated',
                    9002
                );
            }
            return true;
        }

        return false;
    }
}