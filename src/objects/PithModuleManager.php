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


// Pith Module Manager
// -------------------

namespace Pith\Framework;

class PithModuleManager implements PithModuleManagerInterface
{
    private $app;
    public $modules;

    public function whereAmI()
    {
        return "Pith Module Manager";
    }


    public function init($app){
        $this->app = $app;
    }

    public function loadModules(){
        $module_list_filename = (string) $this->app->config->profile->module_list_location;
        $modules = [];

        require $module_list_filename;

        $this->modules = $modules;
    }

    public function findModule(string $module_name)
    {
        return (isset($this->modules[$module_name])) ? $this->modules[$module_name] : false;
    }

    public function getBaseModuleName()
    {
        return (string) $this->app->config->profile->base_module;
    }
}