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
 * Pith Unit Conversion Utility
 * ----------------------------
 *
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For Readability
 */


declare(strict_types=1);

namespace Pith\Framework\Internal;

/**
 * Class PithUnitConversionUtility
 * @package Pith\Framework\Internal
 */
class PithUnitConversionUtility
{
    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     * See:
     *     https://www.php.net/manual/en/function.filesize.php
     *     Comment by rommel at rommelsantor dot com
     *
     * @noinspection SpellCheckingInspection
     */
    public function getHumanFilesize($bytes, $decimals = 2): string
    {
        //$sizes_string = 'BKMGTP';
        //$sizes = str_split($sizes_string);
        //$sizes = ['b', 'kb','mb','gb','tb', 'pb'];
        $sizes = [' Bytes', ' Kilobytes', ' Megabytes', ' Gigabytes', ' Terabytes', ' Petabytes'];

        $bytes_as_string = (string)$bytes;
        $factor = floor((strlen($bytes_as_string) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sizes[$factor];
    }

}