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
 * PithRowsetArrayUtility
 * ----------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok here.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok here.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok here.
 */


declare(strict_types=1);


namespace Pith\Framework\Internal;


/**
 * Class PithRowsetArrayUtility
 * @package Pith\Framework\Internal
 */
class PithRowsetArrayUtility
{

    public function __construct()
    {
        // Do nothing for now.
    }


    /**
     * @param  $rows
     * @param  $field_name
     * @param  $field_value
     * @return array|null
     */
    public function getRowByFieldValue($rows, $field_name, $field_value): ?array
    {
        $r = null;
        $first_index_found = array_search($field_value, array_column($rows, $field_name), true);

        if ($first_index_found !== false) {
            $r = $rows[$first_index_found];
        }

        return $r;
    }
}