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


// Pith App Helper
// ---------------


namespace Pith\Framework\Internal;


class PithAppHelper
{
    function __construct()
    {
        // Do nothing for now
    }

    public function initializeDependencies($app)
    {
        $app->request_processor->init($app);
        $app->router->init($app);
        $app->dispatcher->init($app);
        $app->problem_handler->init($app);
    }
}