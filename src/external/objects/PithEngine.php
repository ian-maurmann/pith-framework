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
 * Pith Engine
 * -----------
 *
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework;

use Pith\Framework\Internal\PithAppReferenceTrait;

// ┌────────────────────────────────────────────────────────────────────────┐
// │    PithEngine                                                          │
// ├────────────────────────────────────────────────────────────────────────┤
// │    +  app : PithApp reference                                          │
// ├────────────────────────────────────────────────────────────────────────┤
// │    ~  __construct( ) : void                                            │
// │    +  start( )       : void                                            │
// └────────────────────────────────────────────────────────────────────────┘

/**
 * Class PithEngine
 * @package Pith\Framework
 */
class PithEngine
{
    use PithAppReferenceTrait;

    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     * @throws PithException
     */
    public function start()
    {
        // Get route
        $route = $this->app->router->getRoute();

        // Dispatch route
        $this->app->dispatcher->engineDispatch($route);
    }

}