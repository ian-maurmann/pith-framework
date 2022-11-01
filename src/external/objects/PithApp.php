<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

/**
 * Pith App
 * --------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework;

use Pith\DatabaseWrapper\PithDatabaseWrapper;
use Pith\Framework\Internal\PithAppHelper;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PithApp
 * @package Pith\Framework
 */
class PithApp
{
    use PithRunTrait;
    use PithStartupTrait;
    use PithVersionTrait;

    private $helper;

    public $access_control;
    public $authenticator;
    public $autoloader;
    public $config;
    public $container;
    public $db;
    public $dispatcher;
    public $engine;
    public $info;
    public $log;
    public $registry;
    public $request;
    public $responder;
    public $router;


    /**
     * PithApp constructor.
     *
     * @param PithAppHelper        $helper
     * @param PithAccessControl    $access_control
     * @param PithConfig           $config
     * @param PithDatabaseWrapper  $db
     * @param PithDispatcher       $dispatcher
     * @param PithEngine           $engine
     * @param PithInfo             $info
     * @param PithResponder        $responder
     * @param PithRouter           $router
     */
    public function __construct(
        PithAppHelper        $helper,
        PithAccessControl    $access_control,
        PithConfig           $config,
        PithDatabaseWrapper  $db,
        PithDispatcher       $dispatcher,
        PithEngine           $engine,
        PithInfo             $info,
        PithResponder        $responder,
        PithRouter           $router
    )
    {
        $this->helper            = $helper;
        $this->access_control    = $access_control;
        $this->authenticator     = null;
        $this->config            = $config;
        $this->container         = null;
        $this->db                = $db;
        $this->dispatcher        = $dispatcher;
        $this->engine            = $engine;
        $this->info              = $info;
        $this->log               = null;
        $this->registry          = null;
        $this->request           = Request::createFromGlobals();
        $this->responder         = $responder;
        $this->router            = $router;


        $helper->initializeDependencies($this);
    }


    /**
     * @return string
     */
    public function whereAmI(): string
    {
        return 'Pith App object';
    }
}

