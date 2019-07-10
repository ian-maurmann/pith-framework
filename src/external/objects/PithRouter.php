<?php
# ===================================================================
# Copyright (c) 2009-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Router
// -----------


declare(strict_types=1);

namespace Pith\Framework;

use Pith\Framework\Internal\PithStringUtility;
use Pith\Framework\Internal\PithProblemHandler;


class PithRouter implements PithRouterInterface
{
    private $app;
    private $string_utility;
    private $problem_handler;

    function __construct(PithStringUtility $string_utility, PithProblemHandler $problem_handler)
    {
        $this->string_utility  = $string_utility;
        $this->problem_handler = $problem_handler;
    }



    public function whereAmI()
    {
        return "Pith Router";
    }


    public function init($app){
        $this->app = $app;
    }





    public function getRoute(){

        $route = null;

        // Get the app route
        $app_route = $this->findAppRouteFromUrl();


        // (On error, redirect to the 404 page)
        if(!$app_route){
            $this->problem('Pith_Provisional_Notice_B5_000', $this->app->request_processor->getRequestPath() );
        }


        // Get the module
        $module = $this->app->container->get($app_route['module']);


        // (On error, redirect to the 501 page)
        if(!$module){
            $this->problem('Pith_Provisional_Error_B5_001', $app_route['match'], $app_route['module']);
        }


        // Get the route name
        $route_name = $app_route['route-name'];


        // Get the route
        $route = $this->findModuleRouteByRouteName($module, $route_name);


        // (On error, redirect to the 501 page)
        if(!$route){
            $this->problem('Pith_Provisional_Error_B5_002', $app_route['route-name'], $app_route['module']);
        }

        return $route;
    }





    public function findAppRouteFromUrl()
    {
        $string_utility = $this->string_utility;
        $request_path   = (string) $this->app->request_processor->getRequestPath();
        $routes         = $this->app->config->getRouteList();
        $matching_route = null;

        foreach($routes as $route_index => $route){
            $match    = (string) $route['match'];
            $is_match = $string_utility->isRouteMatch($request_path, $match);

            if($is_match){
                $matching_route = $route;
                break;
            }
        }

        return $matching_route;
    }


    public function findModuleRouteByRouteName($module, $given_route_name)
    {
        $routes         = $module->listRoutes();
        $matching_route = null;

        foreach($routes as $route_name => $route){
            if( (string) $route_name === (string) $given_route_name){
                $matching_route = $route;
                break;
            }
        }

        return $matching_route;

    }


    public function problem($problem_name, ...$info)
    {
        $this->problem_handler->handleProblem($problem_name, ...$info);
    }

}