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


// Pith Array Utility
// ------------------

namespace Pith\Framework\Internal;


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
                // TODO - We should add a max here, just in-case the array contains a reference to itself / parent and then loops forever
                $return = $this->flatten($item, $return);
            }
            else{
                $return[] = $item;
            }
        }

        return $return;
    }
}