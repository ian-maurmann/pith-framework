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
 * Pith URI Utility
 * ----------------
 *
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For Readability
 */


declare(strict_types=1);

namespace Pith\Framework\Internal;

/**
 * Class PithUriUtility
 * @package Pith\Framework\Internal
 */
class PithUriUtility
{
    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     * @param $uri_string
     * @return array
     *
     * @noinspection PhpCastIsUnnecessaryInspection - Ignore
     */
    public function breakUriIntoPathAndQuery($uri_string): array
    {
        $uri_parts     = explode('?', (string) $uri_string, 2);
        $request_path  = (string) $uri_parts[0];
        $request_query = (isset($uri_parts[1])) ? (string) $uri_parts[1] : '' ;
        $parts_array   = [$request_path, $request_query];

        return $parts_array;
    }


}