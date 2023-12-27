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
        // Gather the calendar info
        $year_yyyy              = $given_datetime->format('Y');
        $january_first_datetime = new DateTime('1 January ' . $year_yyyy);

        return $january_first_datetime;
    }

}