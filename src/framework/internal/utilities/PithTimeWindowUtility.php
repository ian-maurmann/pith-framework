<?php
# ===================================================================
# Copyright (c) 2008-2025 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================



/**
 * Pith Time Window Utility
 * ------------------------
 *
 * @noinspection PhpUnnecessaryLocalVariableInspection - For Readability
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Internal;

use DateTime;
use Exception;

/**
 * Class PithTimeWindowUtility
 * @package Pith\Framework\Internal
 */
class PithTimeWindowUtility
{
    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     * @throws Exception
     */
    public function getWindowStartDatetimeByTimeframeString(DateTime $given_datetime, string $timeframe_mode_string): DateTime
    {
        // Get the start datetime based on the timeframe mode
        return match ($timeframe_mode_string) {
            'window 10 minute' => $this->get10MinuteWindowStartDatetime($given_datetime),
            'window 12 minute' => $this->get12MinuteWindowStartDatetime($given_datetime),
            'window 15 minute' => $this->get15MinuteWindowStartDatetime($given_datetime),
            'window 20 minute' => $this->get20MinuteWindowStartDatetime($given_datetime),
            'window 30 minute' => $this->get30MinuteWindowStartDatetime($given_datetime),
            'window 1 hour'    => $this->getHourWindowStartDatetime($given_datetime),
            'window 1 day'     => $this->getDayWindowStartDatetime($given_datetime),
            'window 1 month'   => $this->getMonthWindowStartDatetime($given_datetime),
            'window 1 year'    => $this->getYearWindowStartDatetime($given_datetime),

            default => false,
        };
    }

    /**
     * @param $time_ago_in_seconds
     * @return DateTime
     * @throws Exception
     */
    public function getDatetimeByTimeAgo($time_ago_in_seconds): DateTime
    {
        $time_ago = time() - $time_ago_in_seconds;
        $time_ago_datetime = new DateTime('@' . $time_ago);

        return $time_ago_datetime;
    }

    /**
     * @throws Exception
     */
    public function getYearWindowStartDatetime(DateTime $given_datetime): DateTime
    {
        // Get the year
        $year_yyyy = $given_datetime->format('Y');

        // Get the first day of the year
        $january_first_datetime = new DateTime($year_yyyy . '-01-01');

        return $january_first_datetime;
    }

    /**
     * @throws Exception
     */
    public function getMonthWindowStartDatetime(DateTime $given_datetime): DateTime
    {
        // Gather the calendar info
        $year_yyyy = $given_datetime->format('Y');
        $month_mm  = $given_datetime->format('m');

        // Get the first day of the month
        $month_datetime = new DateTime($year_yyyy . '-' . $month_mm . '-01');

        return $month_datetime;
    }

    /**
     * @throws Exception
     */
    public function getDayWindowStartDatetime(DateTime $given_datetime): DateTime
    {
        // Gather the calendar info
        $year_yyyy = $given_datetime->format('Y');
        $month_mm  = $given_datetime->format('m');
        $day_dd    = $given_datetime->format('d');

        // Get datetime at start of day
        $day_datetime = new DateTime($year_yyyy . '-' . $month_mm . '-' . $day_dd);

        return $day_datetime;
    }

    public function getHourWindowStartDatetime(DateTime $given_datetime): DateTime
    {
        // Gather the calendar info
        $year_yyyy = $given_datetime->format('Y');
        $month_mm  = $given_datetime->format('m');
        $day_dd    = $given_datetime->format('d');
        $hour_hh   = $given_datetime->format('H');

        // Get datetime at start of hour
        $hour_datetime = DateTime::createFromFormat('Y-m-d H', $year_yyyy . '-' . $month_mm . '-' . $day_dd . ' ' . $hour_hh);

        return $hour_datetime;
    }

    /** @noinspection DuplicatedCode */
    public function get30MinuteWindowStartDatetime(DateTime $given_datetime): DateTime
    {
        // Gather the calendar info
        $year_yyyy = $given_datetime->format('Y');
        $month_mm  = $given_datetime->format('m');
        $day_dd    = $given_datetime->format('d');
        $hour_hh   = $given_datetime->format('H');
        $minute_ii = $given_datetime->format('i');

        // Find 30 minute window
        $window_minute_ii = '00';
        $given_minute_int = (int) $minute_ii;
        if($given_minute_int >= 30){
            $window_minute_ii = '30';
        }

        // Get datetime at start of 30 minute window
        $window_datetime = DateTime::createFromFormat('Y-m-d H:i', $year_yyyy . '-' . $month_mm . '-' . $day_dd . ' ' . $hour_hh . ':' . $window_minute_ii);

        return $window_datetime;
    }

    /** @noinspection DuplicatedCode */
    public function get20MinuteWindowStartDatetime(DateTime $given_datetime): DateTime
    {
        // Gather the calendar info
        $year_yyyy = $given_datetime->format('Y');
        $month_mm  = $given_datetime->format('m');
        $day_dd    = $given_datetime->format('d');
        $hour_hh   = $given_datetime->format('H');
        $minute_ii = $given_datetime->format('i');

        // Find 20 minute window
        $window_minute_ii = '00';
        $given_minute_int = (int) $minute_ii;
        if($given_minute_int >= 40){
            $window_minute_ii = '40';
        }
        elseif($given_minute_int >= 20){
            $window_minute_ii = '20';
        }

        // Get datetime at start of 20 minute window
        $window_datetime = DateTime::createFromFormat('Y-m-d H:i', $year_yyyy . '-' . $month_mm . '-' . $day_dd . ' ' . $hour_hh . ':' . $window_minute_ii);

        return $window_datetime;
    }

    /** @noinspection DuplicatedCode */
    public function get15MinuteWindowStartDatetime(DateTime $given_datetime): DateTime
    {
        // Gather the calendar info
        $year_yyyy = $given_datetime->format('Y');
        $month_mm  = $given_datetime->format('m');
        $day_dd    = $given_datetime->format('d');
        $hour_hh   = $given_datetime->format('H');
        $minute_ii = $given_datetime->format('i');

        // Find 15 minute window
        $window_minute_ii = '00';
        $given_minute_int = (int) $minute_ii;
        if($given_minute_int >= 45){
            $window_minute_ii = '45';
        }
        elseif($given_minute_int >= 30){
            $window_minute_ii = '30';
        }
        elseif($given_minute_int >= 15){
            $window_minute_ii = '15';
        }

        // Get datetime at start of 15 minute window
        $window_datetime = DateTime::createFromFormat('Y-m-d H:i', $year_yyyy . '-' . $month_mm . '-' . $day_dd . ' ' . $hour_hh . ':' . $window_minute_ii);

        return $window_datetime;
    }

    /** @noinspection DuplicatedCode */
    public function get12MinuteWindowStartDatetime(DateTime $given_datetime): DateTime
    {
        // Gather the calendar info
        $year_yyyy = $given_datetime->format('Y');
        $month_mm  = $given_datetime->format('m');
        $day_dd    = $given_datetime->format('d');
        $hour_hh   = $given_datetime->format('H');
        $minute_ii = $given_datetime->format('i');

        // Find 12 minute window
        $window_minute_ii = '00';
        $given_minute_int = (int) $minute_ii;
        if($given_minute_int >= 48){
            $window_minute_ii = '48';
        }
        elseif($given_minute_int >= 36){
            $window_minute_ii = '36';
        }
        elseif($given_minute_int >= 24){
            $window_minute_ii = '24';
        }
        elseif($given_minute_int >= 12){
            $window_minute_ii = '12';
        }

        // Get datetime at start of 12 minute window
        $window_datetime = DateTime::createFromFormat('Y-m-d H:i', $year_yyyy . '-' . $month_mm . '-' . $day_dd . ' ' . $hour_hh . ':' . $window_minute_ii);

        return $window_datetime;
    }

    /** @noinspection DuplicatedCode */
    public function get10MinuteWindowStartDatetime(DateTime $given_datetime): DateTime
    {
        // Gather the calendar info
        $year_yyyy = $given_datetime->format('Y');
        $month_mm  = $given_datetime->format('m');
        $day_dd    = $given_datetime->format('d');
        $hour_hh   = $given_datetime->format('H');
        $minute_ii = $given_datetime->format('i');

        // Find 10 minute window
        $window_minute_ii = '00';
        $given_minute_int = (int) $minute_ii;
        if($given_minute_int >= 50){
            $window_minute_ii = '50';
        }
        elseif($given_minute_int >= 40){
            $window_minute_ii = '40';
        }
        elseif($given_minute_int >= 30){
            $window_minute_ii = '30';
        }
        elseif($given_minute_int >= 20){
            $window_minute_ii = '20';
        }
        elseif($given_minute_int >= 10){
            $window_minute_ii = '10';
        }

        // Get datetime at start of 10 minute window
        $window_datetime = DateTime::createFromFormat('Y-m-d H:i', $year_yyyy . '-' . $month_mm . '-' . $day_dd . ' ' . $hour_hh . ':' . $window_minute_ii);

        return $window_datetime;
    }

    public function isCoolDownOver(int $current_timestamp, int $file_modified_timestamp, string $timeframe_mode_string): bool
    {
        $is_cool_down_over = false;
        $time_elapsed = $current_timestamp - $file_modified_timestamp;

        $cool_down_length = match ($timeframe_mode_string) {
            'after 5 minute'   => 300,      //        300 seconds =   5 minutes
            'after 10 minute'  => 600,      //        600 seconds =  10 minutes
            'after 12 minute'  => 720,      //        720 seconds =  12 minutes
            'after 15 minute'  => 900,      //        900 seconds =  15 minutes
            'after 20 minute'  => 1200,     //      1,200 seconds =  20 minutes
            'after 30 minute'  => 1800,     //      1,800 seconds =  30 minutes
            'after 1 hour'     => 3600,     //      3,600 seconds =   1 hour
            'after 4 hour'     => 14400,    //     14,400 seconds =   4 hours
            'after 8 hour'     => 28800,    //     28,800 seconds =   8 hours
            'after 12 hour'    => 43200,    //     43,200 seconds =  12 hours
            'after 1 day'      => 86400,    //     86,400 seconds =   1 day
            'after 30 day'     => 2592000,  //  2,592,000 seconds =  30 days
            'after 365 day'    => 31536000, // 31,536,000 seconds = 365 days
            default => false,
        };

        if($time_elapsed >= $cool_down_length){
            $is_cool_down_over = true;
        }

        return $is_cool_down_over;
    }
}