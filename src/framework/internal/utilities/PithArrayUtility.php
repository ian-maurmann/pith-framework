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
 * Pith Array Utility
 * ------------------
 *
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok here.
 */


declare(strict_types=1);


namespace Pith\Framework\Internal;


/**
 * Class PithArrayUtility
 * @package Pith\Framework\Internal
 */
class PithArrayUtility
{
    public function __construct()
    {
        // Do nothing for now.
    }


    /**
     * @param $array
     * @param array $return
     * @return array
     *
     * TODO - We should add a max here, just in-case the array contains a reference to itself / parent and then loops forever
     */
    public function flatten($array, array $return = []): array
    {
        foreach ($array as $item) {
            if (is_array($item)) {
                // TODO - We should add a max here, just in-case the array contains a reference to itself / parent and then loops forever
                $return = $this->flatten($item, $return);
            } else {
                $return[] = $item;
            }
        }

        return $return;
    }

    /**
     * @param array $given_array
     * @param string $given_value
     * @return bool
     * @noinspection SpellCheckingInspection - Ignore "strtolower"
     */
    public function arrayHasValueInsensitive(array $given_array, string $given_value): bool
    {
        $value_lower = strtolower($given_value);
        $array_lower = array_map('strtolower', $given_array);
        return in_array($value_lower, $array_lower);
    }



    /**
     * @return string
     */
    public function whereAmI(): string
    {
        return 'Pith Array Utility';
    }
}