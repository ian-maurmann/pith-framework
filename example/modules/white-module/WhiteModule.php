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


// White Example Module
// --------------------

namespace Pith\WhiteModule;

class WhiteModule implements \Pith\Framework\PithModuleInterface
{
    private $route_spaces;

    function __construct()
    {
        $this->initRouteSpaces();
    }


    public function whereAmI()
    {
        return "White Module";
    }

    public function initRouteSpaces(){
        $route_spaces = [

            'main-route-space' => [


                'hello-route' => [
                    'route-name'   => 'hello-route',
                    'path'         => 'hello/',
                    'layout'       => null,
                    'controller'   => '',
                    'access-level' => 'world',
                    'injector'     => '',
                    'action'       => '',
                    'preparer'     => '',
                    'view'         => '',
                ],


                'index-route' => [
                    'route-name'   => 'index-route',
                    'path'         => '',
                    'layout'       => null,
                    'controller'   => '',
                    'access-level' => 'world',
                    'injector'     => '',
                    'action'       => '',
                    'preparer'     => '',
                    'view'         => '',
                ],
            ],


        ];

        $this->route_spaces = $route_spaces;

    }

    public function findRouteSpace($route_space_name){
        $route_space_exists = isset($this->route_spaces[$route_space_name]);
        $route_space        = ($route_space_exists) ? $this->route_spaces[$route_space_name] : false ;

        return $route_space;
    }


}