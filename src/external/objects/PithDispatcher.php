<?php
# ===================================================================
# Copyright (c) 2008-2021 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Dispatcher
// ---------------


declare(strict_types=1);

namespace Pith\Framework;

use Pith\Framework\Internal\PithStringUtility;
use Pith\Framework\Internal\PithProblemHandler;


class PithDispatcher
{
    private $app;
    private $string_utility;
    private $problem_handler;

    function __construct(PithStringUtility $string_utility, PithProblemHandler $problem_handler)
    {
        $this->string_utility  = $string_utility;
        $this->problem_handler = $problem_handler;
    }


    public function init($app)
    {
        $this->app = $app;
    }


    public function whereAmI()
    {
        return 'Pith Dispatcher';
    }

    public function dispatch($route, $secondary_route=null)
    {
        if($route->route_type === 'layout'){
            $this->dispatch_route($route, $secondary_route);
        }
        elseif($route->route_type === 'page' || $route->route_type === 'error-page'){
            if($route->use_layout){
                $this->app->runLayout($route->layout_app_route_name, $route);
            }
            else{
                $this->dispatch_route($route);
            }
        }
        elseif($route->route_type === 'partial'){
            $this->dispatch_route($route);
        }

    }

    public function dispatch_route($route, $secondary_route=null)
    {
        // Start the output buffer
        ob_start();



//        echo '<hr/>';
//        echo '<h3>Route</h3>';
//        echo '<pre><code>';
//        var_dump($route);
//        echo '</code></pre>';



        // Get the controller
        $controller = false;
        try {
            $controller = $this->app->container->get($route->controller_name_with_namespace);
        }
        catch (\DI\NotFoundException $e) {
            $this->app->problem('Pith_Provisional_Error_B6_000', $route->route_name, $route->controller_name_with_namespace);
        }


        
        //echo $controller->whereAmI();


        //-----------------------------------------------

        // Run Access
        $controller->access();


        // Get the access level
        $access_level_name = $controller->getAccessLevel();


        // Clear the access level
        $controller->resetAccessLevel();


        // TODO: process the access here

        $is_allowed = $this->app->access_control->isAllowedToAccess($access_level_name);

        if(!$is_allowed){
            // If not logged in:
            $this->app->problem('Pith_Provisional_Error_C3_000', $route->route_name, $route->controller_name_with_namespace, $access_level_name);

            // If logged in: // TODO
            // Pith_Provisional_Error_C3_001 // TODO
        }

//        echo '<hr/>';
//
//        echo '<h3>Access Level</h3>';
//        echo '<pre><code>';
//        var_dump($access_level_name);
//        echo '</code></pre>';
//
//        echo '<h3>Is Allowed</h3>';
//        echo '<pre><code>';
//        var_dump($is_allowed);
//        echo '</code></pre>';




        //-----------------------------------------------



        // Run Injector
        $controller->injector($this->app);


        // Get the Injector's "inject"
        $inject = $controller->getInject();


        // Clear the Injector's "inject"
        $controller->resetInject();



//        echo '<hr/>';
//        echo '<h3>Inject</h3>';
//        echo '<pre><code>';
//        var_dump($inject);
//        echo '</code></pre>';



        //-----------------------------------------------







        // Run Action
        $controller->action($this->app, $inject);


        // Get the Actions's "prepare"
        $prepare = $controller->getPrepare();


        // Clear the Action's "prepare"
        $controller->resetPrepare();



//        echo '<hr/>';
//        echo '<h3>Action</h3>';
//        echo '<pre><code>';
//        var_dump($prepare);
//        echo '</code></pre>';





        //-----------------------------------------------






        // Run Preparer
        $controller->preparer($this->app, $prepare);


        // Get the Preparer's "view"
        $view = $controller->getView();


        // - - - - - - - - - - - -

        $view_adapter = $controller->getViewAdapter();


        // - - - - - - - - - - - -


        // Clear the Preparer's "view"
        $controller->resetView();



//         echo '<hr/>';
//         echo '<h3>Preparer</h3>';
//         echo '<pre><code>';
//         var_dump($view);
//         echo '</code></pre>';





        //-----------------------------------------------


        // - - - - - - - - - - - -

        $view_full_path = $route->view_full_path;

        $view_adapter->setApp($this->app);
        $view_adapter->setFilePath($view_full_path);
        $view_adapter->setVars($view);

        if(!empty($secondary_route)){
            $view_adapter->setIsLayout(true);
            $view_adapter->setContentRoute($secondary_route);
        }

        $view_adapter->run();

        // - - - - - - - - - - - -




        // Flush the output buffer
        ob_end_flush();
    }






}



