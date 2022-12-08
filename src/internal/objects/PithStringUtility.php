<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


/**
 * Pith String Utility
 * -------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class name is ok here.
 */


declare(strict_types=1);


namespace Pith\Framework\Internal;


/**
 * Class PithStringUtility
 * @package Pith\Framework\Internal
 */
class PithStringUtility
{
    public function __construct(){
        // Do nothing for now
    }

    /*
        Replacements:
        -------------------------------------------
        startsWith --- Use PHP 8 str_starts_with( )
        endsWith   --- Use PHP 8 str_ends_with( )
        -------------------------------------------
    */
}