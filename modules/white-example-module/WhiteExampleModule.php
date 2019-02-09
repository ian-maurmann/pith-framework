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

namespace Pith\WhiteExampleModule;

class WhiteExampleModule implements \Pith\Framework\PithModuleInterface
{
    private $route_spaces;

    function __construct()
    {
        $this->initRouteSpaces();
    }


    public function whereAmI()
    {
        return "White Example Module";
    }

    public function initRouteSpaces(){
        $route_spaces = [

            'main-route-space' => [


                'index-route' => [
                    'route-name'   => 'index-route',
                    'layout'       => null,
                    'controller'   => '',
                    'access-level' => 'world',
                    'injector'     => '',
                    'action'       => '',
                    'preparer'     => '',
                    'view'         => '',
                ],


                'hello-route' => [
                    'route-name'   => 'hello-route',
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
}
