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
 * Pith App Helper
 * ---------------
 *
 * @noinspection PhpMethodNamingConventionInspection - Long method names are ok.
 */
declare(strict_types=1);


namespace Pith\Framework\Internal;


/**
 * Class PithAppHelper
 * @package Pith\Framework\Internal
 */
class PithAppHelper
{
    public function __construct()
    {
        // Do nothing for now
    }


    /**
     * @param $app
     */
    public function initializeDependencies($app)
    {
        // Using secondary initialization function // TODO remove 0.6 implementation
        $app->request_processor->init($app);
        $app->access_control->init($app);
        $app->dispatcher->init($app);
        $app->problem_handler->init($app);

        // Using the app reference trait
        $app->engine->setAppReference($app);
        $app->info->setAppReference($app);
        $app->router->setAppReference($app);
    }
}