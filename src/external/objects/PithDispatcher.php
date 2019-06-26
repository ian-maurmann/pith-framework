<?php
# ===================================================================
# Copyright (c) 2009-2019 Ian K Maurmann. The Pith Framework is
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

use Pith\Framework\Internal\PithAccessDispatchHelper;
use Pith\Framework\Internal\PithStringUtility;
use Pith\Framework\Internal\PithProblemHandler;


class PithDispatcher
{
    private $app;
    private $access_dispatch_helper;
    private $string_utility;
    private $problem_handler;

    function __construct(PithAccessDispatchHelper $access_dispatch_helper,PithStringUtility $string_utility, PithProblemHandler $problem_handler)
    {
        $this->string_utility = $string_utility;
        $this->problem_handler = $problem_handler;
        $this->access_dispatch_helper = $access_dispatch_helper;
    }


    public function init($app)
    {
        $this->app = $app;

        $this->access_dispatch_helper->init($app);
    }


    public function whereAmI()
    {
        return 'Pith Dispatcher';
    }



    public function dispatch($route)
    {
        $controller             = null;
        $dispatch               = null;
        $access_dispatch_helper = $this->access_dispatch_helper;

        // Start the output buffer
        ob_start();

        echo '<pre><code>';
        var_dump($route);
        echo '</code></pre>';



        // Reset Dispatch
        $this->app->dispatch_info->reset();


        // Get the controller
        try {
            $controller = $this->app->container->get($route['controller']);
        }
        catch (\DI\NotFoundException $e) {
            $this->app->problem('Pith_Provisional_Error_B6_000', $route['route-name'], $route['controller']);
        }


        
        echo $controller->whereAmI();


        // Run Access
        $controller->access($access_dispatch_helper);


        $access_level = $this->app->dispatch_info->access_level;

        //echo $access_level;

        // TODO: process the access here


        $injected_array = $controller->injector($this->app, (object) array());







        // Flush the output buffer
        ob_end_flush();
    }






}



