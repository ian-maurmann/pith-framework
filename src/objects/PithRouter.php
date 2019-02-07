<?php
# ===================================================================
# Copyright (c) 2009-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Pith Router
// -----------

namespace Pith\Framework;

class PithRouter implements PithRouterInterface
{
    private $app;
    private $routes;

    public function whereAmI()
    {
        return "Pith Router";
    }


    public function init($app){
        $this->app = $app;
    }

    public function loadRoutes(){
        $route_list_filename = (string) $this->app->config->profile->route_list_location;
        $routes = [];

        require $route_list_filename;

        $this->routes = $routes;
    }

    public function findRoute(string $route_name)
    {
        return (isset($this->routes[$route_name])) ? $this->routes[$route_name] : false;
    }

    public function setModuleRouteList($routes){
        $this->routes = $routes;
    }



}