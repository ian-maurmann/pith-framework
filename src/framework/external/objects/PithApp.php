<?php
# ===================================================================
# Copyright (c) 2008-2023 Ian K Maurmann. The Pith Framework is
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

use Pith\Framework\Internal\PithAppHelper;
use Pith\Framework\Internal\PithEscapeUtility;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PithApp
 * @package Pith\Framework
 */
class PithApp
{
    // Helper
    private PithAppHelper $helper;

    // Objects
    public PithAccessControl   $access_control;
    public object              $authenticator; // TODO
    public object              $autoloader; // Composer Autoloader
    public PithConfig          $config;
    public object              $container; // Planning to just enforce using PHP-DI Container here instead of any PSR-11 container.
    public PithDatabaseWrapper $database;
    public PithDispatcher      $dispatcher;
    public PithEngine          $engine;
    public PithEscapeUtility   $escape;
    public object              $log; // Enforce using Monolog here? Currently any PSR-3 logger.
    public object              $registry; // TODO
    public Request             $request;
    public PithResponder       $responder;
    public PithRouter          $router;


    /**
     * PithApp constructor.
     *
     * @param PithAppHelper       $helper
     * @param PithAccessControl   $access_control
     * @param PithConfig          $config
     * @param PithDatabaseWrapper $database
     * @param PithDispatcher      $dispatcher
     * @param PithEngine          $engine
     * @param PithEscapeUtility   $escape
     * @param PithResponder       $responder
     * @param PithRouter          $router
     */
    public function __construct(
        PithAppHelper       $helper,
        PithAccessControl   $access_control,
        PithConfig          $config,
        PithDatabaseWrapper $database,
        PithDispatcher      $dispatcher,
        PithEngine          $engine,
        PithEscapeUtility   $escape,
        PithResponder       $responder,
        PithRouter          $router
    )
    {
        $this->helper         = $helper;
        $this->access_control = $access_control;
        $this->config         = $config;
        $this->database       = $database;
        $this->dispatcher     = $dispatcher;
        $this->engine         = $engine;
        $this->escape         = $escape;
        $this->request        = Request::createFromGlobals();
        $this->responder      = $responder;
        $this->router         = $router;

        // Other objects:
        // --------------
        // The Autoloader should be added after construct
        // The Container should be added after construct
        // The Log should be added after construct

        // Initialize Dependencies
        $this->helper->initializeDependencies($this);
    }
    
}

