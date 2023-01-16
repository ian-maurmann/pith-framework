<?php
# ===================================================================
# Copyright (c) 2008-2023 Ian K Maurmann. The Pith Framework is
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


use Pith\Framework\PithApp;


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
     * Initialize Dependencies
     *
     * @param PithApp $app
     */
    public function initializeDependencies(PithApp $app)
    {
        // Set app reference
        $app->access_control->setAppReference($app);
        $app->config->setAppReference($app);
        $app->dispatcher->setAppReference($app);
        $app->engine->setAppReference($app);
        $app->responder->setAppReference($app);
        $app->router->setAppReference($app);
    }
}