<?php
# ===================================================================
# Copyright (c) 2008-2021 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Pith Array Utility
// ------------------

namespace Pith\InternalUtilities;


class PithArrayUtility
{

    function __construct()
    {
        // Do nothing for now.
    }


    function flatten($array, $return = [])
    {
        foreach ($array as $item) {
            if(is_array($item)){
                $return = $this->flatten($item, $return);
            }
            else{
                $return[] = $item;
            }
        }

        return $return;
    }
}