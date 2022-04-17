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
 * Pith Responder
 * --------------
 *
 * @noinspection PhpMethodNamingConventionInspection - Long method names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework;

use Pith\Framework\Internal\PithAppReferenceTrait;


/**
 * Class PithResponder
 * @package Pith\Framework
 */
class PithResponder
{
    use PithAppReferenceTrait;

    public function __construct()
    {
        // Do nothing for now.
    }


    /**
     * @param  $route_namespace
     * @throws PithException
     *
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertPartial($route_namespace)
    {
        // Get route
        $route = $this->app->router->getRouteFromRouteNamespace($route_namespace);

        // Run route
        $this->app->dispatcher->engineDispatchRoute($route);
    }


    /**
     * @param  string $layout_namespace
     * @throws PithException
     *
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function runLayout(string $layout_namespace)
    {
        // Get route
        $route = $this->app->router->getRouteFromRouteNamespace($layout_namespace);

        // Run route
        $this->app->dispatcher->engineDispatchRoute($route);
    }


    /**
     * @param  $content_route
     * @throws PithException
     *
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertPageContent($content_route)
    {
        // Run route
        $this->app->dispatcher->engineDispatchRoute($content_route);
    }

}