<?php
# ===================================================================
# Copyright (c) 2008-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Pith App
// --------

namespace Pith\Framework;

use Pith\Framework\Internal\PithProblemHandler;

class PithApp implements PithAppInterface
{
    use PithVersionTrait;

    public $container;
    public $log;
    public $request_processor;
    public $config;
    public $registry;
    public $authenticator;
    public $access_control;
    public $router;
    public $dispatcher;
    public $problem_handler;


    function __construct(
        PithRequestProcessor $request_processor,
        PithConfig           $config,
        PithRouter           $router,
        PithDispatcher       $dispatcher,
        PithProblemHandler   $problem_handler
    )
    {
        $this->container         = null;
        $this->log               = null;
        $this->request_processor = $request_processor;
        $this->config            = $config;
        $this->registry          = null;
        $this->authenticator     = null;
        $this->access_control    = null;
        $this->router            = $router;
        $this->dispatcher        = $dispatcher;
        $this->problem_handler   = $problem_handler;

        $this->request_processor->init($this);
        $this->router->init($this);
        $this->dispatcher->init($this);
        $this->problem_handler->init($this);
    }


    public function whereAmI()
    {
        return "Pith App";
    }

    //-----------------------------------------------

    public function start()
    {
        // Run the framework normally


        // Get the route
        $route = $this->router->routeByUrl();


        // Run everything for the route.
        $this->dispatcher->dispatch($route);
    }

    //-----------------------------------------------

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


    public function problem($problem_name, ...$info)
    {
        $this->problem_handler->handleProblem($problem_name, ...$info);
    }
}


