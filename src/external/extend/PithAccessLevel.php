<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Access Level (extend)
// --------------------------


declare(strict_types=1);


namespace Pith\Framework;


class PithAccessLevel
{
    private $app;


    function __construct()
    {
        // Do nothing for now.
    }


    public function setApp($app)
    {
        $this->app = $app;
    }


    public function getName()
    {
        return 'NOT NAMED';
    }


    public function isAllowedToAccess()
    {
        return false;
    }
}