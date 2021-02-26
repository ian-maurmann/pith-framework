<?php
# ===================================================================
# Copyright (c) 2008-2021 Ian K Maurmann. The Pith Framework is
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
                'route-type' => 'page',
                'use-layout' => false,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/home.phtml',
            ],

            '404' => [
                'route-name' => '404',
                'route-type' => 'error-page',
                'use-layout' => false,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/404.phtml',
            ],

            '501' => [
                'route-name' => '501',
                'route-type' => 'error-page',
                'use-layout' => false,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/505.phtml',
            ],

            'alpha' => [
                'route-name' => 'alpha',
                'route-type' => 'page',
                'use-layout' => false,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/alpha.phtml',
            ],

            'beta' => [
                'route-name' => 'beta',
                'route-type' => 'page',
                'use-layout' => false,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/beta.phtml',
            ],

            'gamma' => [
                'route-name' => 'gamma',
                'route-type' => 'page',
                'use-layout' => false,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/gamma.phtml',
            ],

            'delta' => [
                'route-name' => 'delta',
                'route-type' => 'page',
                'use-layout' => true,
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'views/delta.phtml',
            ],

            'first-layout' => [
                'route-name' => 'first-layout',
                'route-type' => 'layout',
                'controller' => 'Pith\\ExampleModule\\AlphaController',
                'view'       => 'layouts/first-layout.phtml',
            ],

            'first-partial' => [
                'route-name' => 'first-partial',
                'route-type' => 'partial',
                'controller' => 'Pith\\ExampleModule\\FirstPartialController',
                'view'       => 'partial-views/first-partial-view.phtml',
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