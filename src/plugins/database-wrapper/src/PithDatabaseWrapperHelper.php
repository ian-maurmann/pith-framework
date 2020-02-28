<?php
# ===================================================================
# Copyright (c) 2008-2020 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Pith Database Wrapper Helper
// -----------------------------------------

namespace Pith\DatabaseWrapper;


class PithDatabaseWrapperHelper
{

    function __construct()
    {
        // Nothing for now
    }

    public function flattenArgs($args){
        $flat_args = [];

        foreach($args as $arg){
            if(is_array($arg)){
                foreach($arg as $arg_item){
                    $flat_args[] = $arg_item;
                }
            }
            else{
                $flat_args[] = $arg;
            }
        }

        return $flat_args;
    }


}