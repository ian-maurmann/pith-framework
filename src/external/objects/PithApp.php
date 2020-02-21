<?php
# ===================================================================
# Copyright (c) 2008-2020 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith App
// --------


declare(strict_types=1);


namespace Pith\Framework;


use Pith\Framework\Internal\PithProblemHandler;


class PithApp implements PithAppInterface
{
    use PithStartupTrait;
    use PithRunTrait;
    use PithProblemTrait;
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

}


