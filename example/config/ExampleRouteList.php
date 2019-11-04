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


// Example Route List
// ------------------

namespace Pith\ExampleConfig;


class ExampleRouteList
{
    private $routes;



    function __construct()
    {
        $this->createRoutes();
    }




    private function createRoutes()
    {
        $routes = [


            [
                'match'      => '/',
                'module'     => 'Pith\\ExampleModule\\ExampleModule',
                'route-name' => 'index',
                'layout'     => '',
            ],

            [
                'match'      => '/404',
                'module'     => 'Pith\\ExampleModule\\ExampleModule',
                'route-name' => '404',
                'layout'     => '',
            ],

            [
                'match'      => '/501',
                'module'     => 'Pith\\ExampleModule\\ExampleModule',
                'route-name' => '501',
                'layout'     => '',
            ],

            [
                'match'      => '/alpha',
                'module'     => 'Pith\\ExampleModule\\ExampleModule',
                'route-name' => 'alpha',
                'layout'     => '',
            ],

            [
                'match'      => '/beta',
                'module'     => 'Pith\\ExampleModule\\ExampleModule',
                'route-name' => 'beta',
                'layout'     => '',
            ],


            [
                'match'      => '/gamma',
                'module'     => 'Pith\\ExampleModule\\ExampleModule',
                'route-name' => 'gamma',
                'layout'     => '',
            ],

            [
                'match'      => '/delta',
                'module'     => 'Pith\\ExampleModule\\ExampleModule',
                'route-name' => 'delta',
                'layout'     => '',
            ],




        ];

        $this->routes = $routes;
    }



    public function getRouteList(){
        return $this->routes;
    }



    public function whereAmI()
    {
        return 'Example Route List';
    }
}