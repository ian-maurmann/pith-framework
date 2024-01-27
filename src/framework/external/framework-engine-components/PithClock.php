<?php /** @noinspection PhpMethodNamingConventionInspection */
# ===================================================================
# Copyright (c) 2008-2024 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

/**
 * Pith Clock
 * ----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework;

use DateTime;

/**
 * Class PithClock
 * @package Pith\Framework
 */
class PithClock
{
    private int $launch_moment_timestamp;
    private int $launch_moment_hour_timestamp;

    public function __construct()
    {
        // Do nothing for now.
    }

    public function init()
    {
        date_default_timezone_set('UTC');

        $datetime_object = new DateTime(); // Defaults to now.

        $this->launch_moment_timestamp = $datetime_object->getTimestamp();

        $datetime_object->setTime((int) $datetime_object->format('G'), 0); // Current hour, 0 minutes, 0 seconds

        $this->launch_moment_hour_timestamp = $datetime_object->getTimestamp();

    }

    /**
     * @return int
     */
    public function getLaunchMomentTimestamp(): int
    {
        return $this->launch_moment_timestamp;
    }

    /**
     * @return int
     */
    public function getLaunchMomentHourTimestamp(): int
    {
        return $this->launch_moment_hour_timestamp;
    }

}