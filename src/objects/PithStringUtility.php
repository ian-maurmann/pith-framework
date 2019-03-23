<?php
# ===================================================================
# Copyright (c) 2009-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Pith String Utility
// -------------------

namespace Pith\Framework;

class PithStringUtility
{

    /**
     * @return string
     */
    public function whereAmI()
    {
        return "Pith String Utility";
    }

    public function startsWith($full_string, $string_to_find){
        $full_string_lower    = mb_strtolower( (string) $full_string,    'UTF-8');
        $string_to_find_lower = mb_strtolower( (string) $string_to_find, 'UTF-8');
        return substr($full_string_lower, 0, strlen($string_to_find_lower)) === $string_to_find_lower;
    }



}