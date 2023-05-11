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
 * Pith Engine
 * -----------
 *
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework;

use ReflectionException;

// ┌────────────────────────────────────────────────────────────────────────┐
// │    PithEngine                                                          │
// ├────────────────────────────────────────────────────────────────────────┤
// │    +  app : PithApp reference                                          │
// ├────────────────────────────────────────────────────────────────────────┤
// │    ~  __construct( ) : void                                            │
// │    +  start( )       : void                                            │
// └────────────────────────────────────────────────────────────────────────┘

/**
 * Class PithEngine
 * @package Pith\Framework
 */
class PithEngine
{
    private PithConfig     $config;
    private PithRouter     $router;
    private PithDispatcher $dispatcher;

    public function __construct(PithConfig $config, PithRouter $router, PithDispatcher $dispatcher)
    {
        // Object Dependencies
        $this->config     = $config;
        $this->router     = $router;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @throws PithException|ReflectionException
     */
    public function start()
    {
        // Load config
        $this->config->load();
        
        // Get route
        $route = $this->router->getRoute();

        // Dispatch route
        $this->dispatcher->dispatch($route);
    }

    /**
     * @param  string $route_namespace
     * @throws PithException
     * @throws ReflectionException
     */
    public function runPartial(string $route_namespace)
    {
        // Get route
        $route = $this->router->getRouteFromRouteNamespace($route_namespace);

        // Run route
        $this->dispatcher->dispatchRoute($route);
    }

    /**
     * @param string $layout_namespace
     * @throws PithException
     * @throws ReflectionException
     */
    public function runLayout(string $layout_namespace)
    {
        // Get route
        $route = $this->router->getRouteFromRouteNamespace($layout_namespace);

        // Run route
        $this->dispatcher->dispatchRoute($route);
    }

    /**
     * @param PithRoute $content_route
     * @throws PithException
     * @throws ReflectionException
     */
    public function runPageContent(PithRoute $content_route)
    {
        // Run route
        $this->dispatcher->dispatchRoute($content_route);
    }

}