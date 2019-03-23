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


// Pith App
// --------

namespace Pith\Framework;

class PithApp implements PithAppInterface
{
    use PithVersionTrait;

    public $container         = null;
    public $request_processor = null;
    public $config            = null;
    public $registry          = null;
    public $authenticator     = null;
    public $access_control    = null;
    public $router            = null;
    public $dispatcher        = null;


    function __construct(PithRequestProcessor $request_processor, PithConfig $config, PithRouter $router)
    {
        $this->container         = null;
        $this->request_processor = $request_processor;
        $this->config            = $config;
        $this->registry          = null;
        $this->authenticator     = null;
        $this->access_control    = null;
        $this->router            = $router;
        $this->dispatcher        = null;


        $this->request_processor->init($this);
        $this->router->init($this);


    }


    public function whereAmI()
    {
        return "Pith App";
    }


    public function start()
    {
        // Run the framework normally

        echo 'START<br />';

        // Request
        echo '<hr />';
        echo '<b>' . $this->request_processor->whereAmI() . '</b>';
        echo '<br />';
        echo $this->request_processor->getRequestUri();
        echo '<br />';
        echo $this->request_processor->getRequestPath();
        echo '<br />';
        echo $this->request_processor->getRequestQuery();
        echo '<br />';


        // Config
        echo '<hr />';
        echo '<b>' . $this->config->whereAmI() . '</b>';
        $this->config->loadConfig();

        // Router
        echo '<hr />';
        echo '<b>' . $this->router->whereAmI() . '</b>';

        $app_route_space = $this->router->findRouteSpaceFromUrl();

        // debug
        // =============
        echo '<br/><u>App Route Space</u><br/>';
        echo '<pre>';
        var_dump($app_route_space);
        echo '</pre><br />';
        // =============

        $module = new $app_route_space['module'];

        echo '<br/><u>Module</u><br/>';
        echo $module->whereAmI();
        echo '<br />';


        $route_path = $this->router->findRoutePathFromRouteSpaceAndUrl($app_route_space);

        echo '<br/><u>Route Path</u><br/>';
        echo $route_path;
        echo '<br />';

        $module_route_space_name = $app_route_space['route-space'];

        // debug
        // =============
        echo '<br/><u>Module Route Space Name</u><br/>';
        echo $module_route_space_name;
        echo '<br />';
        // =============

        $module_route_space = $module->findRouteSpace($module_route_space_name);


        // debug
        // =============
        echo '<br/><u>Module Route Space</u><br/>';
        echo '<pre>';
        var_dump($module_route_space);
        echo '</pre><br />';
        // =============


        echo '<hr />';
        echo 'END <br />';
    }


    public function runRoute($module_name, $route_name)
    {
        // Run a specific route without checking the url



    }
}


