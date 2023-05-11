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

/**
 * Class PithApp
 * @package Pith\Framework
 */
class PithApp
{
    // Helper
    private PithAppHelper $helper;

    // Objects
    public PithConfig          $config;
    public PithDispatcher      $dispatcher;
    public PithEngine          $engine;
    public object              $log; // Enforce using Monolog here? Currently any PSR-3 logger.
    public PithResponder       $responder;


    /**
     * PithApp constructor.
     *
     * @param PithAppHelper       $helper
     * @param PithConfig          $config
     * @param PithDispatcher      $dispatcher
     * @param PithEngine          $engine
     * @param PithResponder       $responder
     */
    public function __construct(
        PithAppHelper       $helper,
        PithConfig          $config,
        PithDispatcher      $dispatcher,
        PithEngine          $engine,
        PithResponder       $responder,
    )
    {
        $this->helper         = $helper;
        $this->config         = $config;
        $this->dispatcher     = $dispatcher;
        $this->engine         = $engine;
        $this->responder      = $responder;

        // Other objects:
        // --------------
        // The Log should be added after construct

        // Initialize Dependencies
        $this->helper->initializeDependencies($this);
    }
    
}

