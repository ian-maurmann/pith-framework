<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Query (extend)
// -------------------


declare(strict_types=1);


namespace Pith\Framework;


class PithQuery
{
    private $app;


    function __construct()
    {
        // Do nothing for now
    }


    public function setApp($app)
    {
        $this->app = $app;
    }


    public function run()
    {
        // OVERRIDE

        // Do nothing for now
    }


    protected function paramList($count)
    {
        $separator = ', ';
        $fill      = '?';
        $r         = implode($separator, array_fill(0, (int) $count, $fill));

        return $r;
    }


    protected function paramCount($array)
    {
        $count = count($array);
        $r     = $this->paramList($count);

        return $r;
    }


}