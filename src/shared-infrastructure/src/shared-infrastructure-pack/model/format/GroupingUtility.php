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
 * Grouping Utility
 * ----------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection - Ignore for readability.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4 not PSR-0.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\Format;


/**
 * Class GroupingUtility
 * @package Pith\Framework\SharedInfrastructure\Model\Random
 */
class GroupingUtility
{
    /**
     * @param mixed $given
     * @return string
     */
    public function hyphenDelimitGroupsOfFour(mixed $given): string
    {
        $given_as_string    = (string) $given;
        $delimiter          = '-';
        $delimited          = $given_as_string;
        $whole_length       = mb_strlen($given_as_string);
        $is_4_chars_or_less = $whole_length < 5;

        if(!$is_4_chars_or_less){
            $remainder_length = $whole_length % 4;
            $has_remainder    = $remainder_length > 0;
            $quotient_string  = mb_substr($given_as_string, $remainder_length);
            $quotient_chunks  = mb_str_split($quotient_string, 4);
            $delimited        = implode($delimiter, $quotient_chunks);

            if($has_remainder){
                $remainder_string = mb_substr($given_as_string, 0, $remainder_length);
                $delimited = $remainder_string . $delimiter . $delimited;
            }
        }

        return $delimited;
    }


}