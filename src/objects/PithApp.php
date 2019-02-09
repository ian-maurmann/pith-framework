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

    public $container      = null;
    public $request        = null;
    public $config         = null;
    public $registry       = null;
    public $authenticator  = null;
    public $access_control = null;
    public $router         = null;
    public $dispatcher     = null;


    function __construct(PithRequest $request, PithConfig $config, PithRouter $router)
    {
        $this->container      = null;
        $this->request        = $request;
        $this->config         = $config;
        $this->registry       = null;
        $this->authenticator  = null;
        $this->access_control = null;
        $this->router         = $router;
        $this->dispatcher     = null;


        $this->request->init($this);
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

        // Config
        $this->config->loadConfig();


        echo 'END <br />';
    }


    public function runRoute($module_name, $route_name)
    {
        // Run a specific route without checking the url



    }
}


