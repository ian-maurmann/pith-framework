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


// Pith Request Helper
// -------------------

namespace Pith\Framework\Internal;

class PithRequestHelper
{

    /**
     * @return string
     */
    public function whereAmI()
    {
        return "Pith Request Helper";
    }


    /**
     * @param $uri_string
     * @return array
     */
    public function breakUriIntoPathAndQuery($uri_string)
    {
        $uri_parts     = explode('?', (string) $uri_string, 2);
        $request_path  = (string) $uri_parts[0];
        $request_query = (isset($uri_parts[1])) ? (string) $uri_parts[1] : '' ;

        return array($request_path, $request_query);
    }


}