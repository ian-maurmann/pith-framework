<?php
# ===================================================================
# Copyright (c) 2008-2021 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Run Trait
// --------------


declare(strict_types=1);


namespace Pith\Framework;


trait PithRunTrait
{
    public function runLayout($layout_route_path, $page_route)
    {
        // Get the layout route
        $layout_route = $this->router->routeByAppPath($layout_route_path);

        // Run everything for the layout route
        $this->dispatcher->dispatch($layout_route, $page_route);
    }


    public function runContent($content_route)
    {
        // Run everything for the content route
        $this->dispatcher->dispatch_route($content_route);
    }


    public function runPartial($app_route_path)
    {
        $this->runAppRoute($app_route_path);
    }


    //-----------------------------------------------


    public function runAppRoute($app_route_path)
    {
        // Get the route
        $route = $this->router->routeByAppPath($app_route_path);

        // Run everything for the route.
        $this->dispatcher->dispatch($route);
    }


    public function runModuleRoute($module_name, $route_name)
    {
        // Run a specific route without checking the url

        // TODO
    }


    //-----------------------------------------------


    public function runAppRouteByUrl()
    {
        // Get the route
        $route = $this->router->routeByUrl();


        // Run everything for the route.
        $this->dispatcher->dispatch($route);
    }


}