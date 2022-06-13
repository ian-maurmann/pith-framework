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
 * Pith Config
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */

declare(strict_types=1);


namespace Pith\Framework;

use Pith\Framework\Internal\PithAppReferenceTrait;

/**
 * Class PithConfig
 * @package Pith\Framework
 */
class PithConfig
{
    use PithAppReferenceTrait;

    /**
     * Holds route list object
     * @var PithRouteList | null
    */
    public $route_list = null;

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        // Default to empty array
        $routes = [];

        // Get the routes from the route list
        if($this->route_list){
            $routes = $this->route_list->routes;
        }

        // Return array of routes, or empty array on failure
        return $routes;
    }
}


