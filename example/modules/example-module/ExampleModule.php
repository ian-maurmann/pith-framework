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


// Example Module
// --------------------

namespace Pith\ExampleModule;

class ExampleModule implements \Pith\Framework\PithModuleInterface
{
    private $routes;


    function __construct()
    {
        $this->initRoutes();
    }


    public function whereAmI()
    {
        return "Example Module";
    }



    private function initRoutes()
    {
        $routes = [
            'index' => [
                'route-name' => 'index',
                'use-layout' => true,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/alpha.phtml',
            ],

            '404' => [
                'route-name' => '404',
                'use-layout' => true,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/alpha.phtml',
            ],

            '501' => [
                'route-name' => '501',
                'use-layout' => true,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/alpha.phtml',
            ],

            'alpha' => [
                'route-name' => 'alpha',
                'use-layout' => true,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/alpha.phtml',
            ],

            'beta' => [
                'route-name' => 'beta',
                'use-layout' => true,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/alpha.phtml',
            ],

            'gamma' => [
                'route-name' => 'gamma',
                'use-layout' => true,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/alpha.phtml',
            ],

            'delta' => [
                'route-name' => 'delta',
                'use-layout' => true,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/alpha.phtml',
            ],


        ];

        $this->routes = $routes;
    }




    public function findRoute($route_name)
    {
        $route_exists = isset($this->routes[$route_name]);
        $route        = ($route_exists) ? $this->routes[$route_name] : false ;

        return $route;
    }



    public function listRoutes()
    {
        return $this->routes;
    }

}