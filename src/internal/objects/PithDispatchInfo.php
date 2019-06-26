<?php
# ===================================================================
# Copyright (c) 2009-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Dispatch
// -------------


declare(strict_types=1);

namespace Pith\Framework\Internal;

class PithDispatchInfo
{
    private $app;

    public $access_level;

    function __construct()
    {
        $this->reset();
    }


    public function init($app)
    {
        $this->app = $app;
    }


    public function reset()
    {
        $this->access_level = null;
    }
}