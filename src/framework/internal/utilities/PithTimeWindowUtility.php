<?php
# ===================================================================
# Copyright (c) 2008-2023 Ian K Maurmann. The Pith Framework is
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
}