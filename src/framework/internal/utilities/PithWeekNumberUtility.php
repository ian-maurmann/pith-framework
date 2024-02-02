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
 * Pith Week Number Utility
 * ------------------------
 *
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For Readability
 */


declare(strict_types=1);

namespace Pith\Framework\Internal;

use DateTime;
use Exception;

/**
 * Class PithWeekNumberUtility
 * @package Pith\Framework\Internal
 */
class PithWeekNumberUtility
{
    public function __construct()
    {
        // Do nothing for now.
    }


    /**
     * @throws Exception
     */
    public function getYearWeekNumber($date_as_string): string
    {
        // Get the week number
        $week_int = $this->getWeekNumberInt($date_as_string);

        // Build the full week string
        $given_date_datetime = new DateTime($date_as_string);
        $year_yyyy           = $given_date_datetime->format('Y');
        $week_padded         = str_pad((string)$week_int, 2, '0', STR_PAD_LEFT);
        $year_week           = $year_yyyy . '-w' . $week_padded;

        // Return the full year-week number string
        return $year_week;
    }



    /**
     * @throws Exception
     */
    public function getWeekNumberInt(string $date_as_string): int
    {
        // Default to 0
        $week_int = 0;

        // Gather the calendar info
        $given_date_datetime       = new DateTime($date_as_string);
        $year_yyyy                 = $given_date_datetime->format('Y');
        $january_first_datetime    = new DateTime('1 January ' . $year_yyyy);
        $january_first_weekday_int = (int) $january_first_datetime->format('w');
        $year_day_int              = (int) $given_date_datetime->format('z');

        // Get first day of the first full week
        $first_year_day_of_w01 = 0;
        if($january_first_weekday_int > 0){
            $first_year_day_of_w01 = 7 - $january_first_weekday_int;
        }

        // Find the week of the year
        if($year_day_int < $first_year_day_of_w01){
            $week_int = 0;
        }
        elseif($year_day_int === $first_year_day_of_w01){
            $week_int = 1;
        }
        else{
            $week_int = ((int) ( ($year_day_int - $first_year_day_of_w01) / 7 )) + 1;
        }

        // Return the given date's week of the year as int
        return $week_int;
    }


}