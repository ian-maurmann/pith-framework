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
     * Holds path to the env constants file
     * @var string | null
     */
    public $env_constants_file;

    /**
     * Holds path to the tracked constants file
     * @var string | null
     */
    public $tracked_constants_file;

    /**
     * Holds route list object
     * @var PithRouteList | null
    */
    public $route_list;

    /**
     * Get array of routes for FastRoute.
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

    /** @noinspection PhpIncludeInspection */
    public function load()
    {
        // Load env constants
        require $this->env_constants_file;

        // Load tracked constants
        require $this->tracked_constants_file;
    }
}


