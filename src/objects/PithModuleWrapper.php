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


// Pith Module Wrapper
// -------------------

namespace Pith\Framework;

class PithModuleWrapper implements PithModuleWrapperInterface
{
    private $module_info = array();
    private $routes;


    public function whereAmI()
    {
        return "Pith Module Wrapper";
    }


    public function wrapModuleInfo($module_info){
        $this->module_info = $module_info;
        $this->loadModuleRoutes();
    }

    public function getName()
    {
        return $this->module_info['name'];
    }

    public function getPath()
    {
        return $this->module_info['path'];
    }

    public function getPathToRoutes()
    {
        return $this->getPath() . '/route-list.php';
    }

    public function loadModuleRoutes()
    {
        $path_to_route_list_filename = $this->getPathToRoutes();
        $routes = [];

        require $path_to_route_list_filename;

        $this->routes = $routes;
    }


    public function getRoutes()
    {
        return $this->routes;
    }
}