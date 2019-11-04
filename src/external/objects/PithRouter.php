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
use Pith\Framework\Internal\PithRoute;


class PithRouter implements PithRouterInterface
{
    private $app;
    private $string_utility;
    private $problem_handler;
    private $route_object;

    function __construct(PithStringUtility $string_utility, PithProblemHandler $problem_handler, PithRoute $route_object)
    {
        $this->string_utility  = $string_utility;
        $this->problem_handler = $problem_handler;
        $this->route_object    = $route_object;
    }



    public function whereAmI()
    {
        return "Pith Router";
    }


    public function init($app){
        $this->app = $app;
    }





    public function getRoute(){

        $route_object = null;

        // Get the app route
        $app_route = $this->findAppRouteFromUrl();


        // (On error, redirect to the 404 page)
        if(!$app_route){
            $this->problem('Pith_Provisional_Notice_B5_000', $this->app->request_processor->getRequestPath() );
        }


        $module_name_with_namespace = $app_route['module'];

        // Get the module
        $module = $this->app->container->get($module_name_with_namespace);


        // (On error, redirect to the 501 page)
        if(!$module){
            $this->problem('Pith_Provisional_Error_B5_001', $app_route['match'], $module_name_with_namespace);
        }


        $module_reflector_object = new \ReflectionClass($module_name_with_namespace);
        $module_directory_full_path = dirname($module_reflector_object->getFileName());

        //echo $module_directory_full_path;



        // Get the route name
        $route_name = $app_route['route-name'];


        // Get the route
        $route = $this->findModuleRouteByRouteName($module, $route_name);


        // (On error, redirect to the 501 page)
        if(!$route){
            $this->problem('Pith_Provisional_Error_B5_002', $app_route['route-name'], $app_route['module']);
        }


        $view_relative_path = $route['view'];
        $view_full_path     = $module_directory_full_path . '/' . $view_relative_path;

        $route_object = clone $this->route_object;

        $route_object->route_name                     = $route['route-name'];
        $route_object->use_layout                     = $route['use-layout'];
        $route_object->controller_name_with_namespace = $route['controller'];
        $route_object->module_name_with_namespace     = $app_route['module'];
        $route_object->module_object                  = clone $module;
        $route_object->module_directory_full_path     = $module_directory_full_path;
        $route_object->view_relative_path             = $view_relative_path;
        $route_object->view_full_path                 = $view_full_path;

        return $route_object;
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