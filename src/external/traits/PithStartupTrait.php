<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Startup Trait
// ------------------


declare(strict_types=1);


namespace Pith\Framework;


trait PithStartupTrait
{
    public function start()
    {
        // Run the framework normally
        $this->runAppRouteByUrl();
    }
}