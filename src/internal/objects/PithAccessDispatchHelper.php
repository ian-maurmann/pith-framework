<?php
# ===================================================================
# Copyright (c) 2009-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Access Dispatch Helper
// ---------------------------


declare(strict_types=1);

namespace Pith\Framework\Internal;

class PithAccessDispatchHelper
{
    private $app;

    function __construct()
    {
        // construct
    }


    public function init($app)
    {
        $this->app = $app;
    }


    public function setControllerAccessLevel($access_level){
        $this->app->dispatch_info->access_level = $access_level;
    }
}