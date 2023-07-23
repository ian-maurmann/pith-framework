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

/**
 * Class PithApp
 * @package Pith\Framework
 */
class PithApp
{
    // Objects
    public PithAccessControl  $access_control;
    public PithActiveUser     $active_user;
    public PithCliFormat      $cli_format;
    public PithCliWriter      $cli_writer;
    public PithClock          $clock;
    public PithConfig         $config;
    public PithDispatcher     $dispatcher;
    public PithEngine         $engine;
    public PithResponder      $responder;
    public PithRegistry       $registry;
    public PithRouter         $router;
    public PithSessionManager $session_manager;


    /**
     * @param PithAccessControl $access_control
     * @param PithActiveUser $active_user
     * @param PithCliFormat $cli_format
     * @param PithCliWriter $cli_writer
     * @param PithClock $clock
     * @param PithConfig $config
     * @param PithDispatcher $dispatcher
     * @param PithEngine $engine
     * @param PithRegistry $registry
     * @param PithResponder $responder
     * @param PithRouter $router
     * @param PithSessionManager $session_manager
     */
    public function __construct(
        PithAccessControl  $access_control,
        PithActiveUser     $active_user,
        PithCliFormat      $cli_format,
        PithCliWriter      $cli_writer,
        PithClock          $clock,
        PithConfig         $config,
        PithDispatcher     $dispatcher,
        PithEngine         $engine,
        PithRegistry       $registry,
        PithResponder      $responder,
        PithRouter         $router,
        PithSessionManager $session_manager
    )
    {
        // Set object dependencies
        $this->access_control  = $access_control;
        $this->active_user     = $active_user;
        $this->cli_format      = $cli_format;
        $this->cli_writer      = $cli_writer;
        $this->clock           = $clock;
        $this->config          = $config;
        $this->dispatcher      = $dispatcher;
        $this->engine          = $engine;
        $this->registry        = $registry;
        $this->responder       = $responder;
        $this->router          = $router;
        $this->session_manager = $session_manager;

        // Init the clock
        $this->clock->init();

        // Startup the active user
        $this->active_user->init();
    }
    
}

