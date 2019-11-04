<?php
# ===================================================================
# Copyright (c) 2008-2019 Ian K Maurmann. The Pith Framework is
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



    public function dispatch($route)
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
        $access_level = $controller->getAccessLevel();


        // Clear the access level
        $controller->resetAccessLevel();


        // TODO: process the access here


//        echo '<hr/>';
//        echo '<h3>Access Level</h3>';
//        echo '<pre><code>';
//        var_dump($access_level);
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

        $view_adapter->setFilePath($view_full_path);
        $view_adapter->setVars($view);
        $view_adapter->run();

        // - - - - - - - - - - - -




        // Flush the output buffer
        ob_end_flush();
    }






}



