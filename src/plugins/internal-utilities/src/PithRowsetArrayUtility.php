<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Pith Rowset Array Utility
// -------------------------

namespace Pith\InternalUtilities;


class PithRowsetArrayUtility
{

    function __construct()
    {
        // Do nothing for now.
    }


    public function getRowByFieldValue($rows, $field_name, $field_value)
    {
        $r     = null;
        $index = array_search($field_value, array_column($rows, $field_name), true );

        if($index !== false){
            $r = $rows[$index];
        }

        return $r;
    }
}