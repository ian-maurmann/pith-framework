<?php
# ===================================================================
# Copyright (c) 2008-2024 Ian K Maurmann. The Pith Framework is
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

use Pith\Workflow\PithRoute;
use ReflectionException;


/**
 * Class PithEngine
 * @package Pith\Framework
 */
class PithEngine
{
    private PithAppRetriever $app_retriever;
    private PithConfig       $config;
    private PithRouter       $router;
    private PithDispatcher   $dispatcher;

    public function __construct(PithAppRetriever $app_retriever, PithConfig $config, PithRouter $router, PithDispatcher $dispatcher)
    {
        // Object Dependencies
        $this->app_retriever = $app_retriever;
        $this->config        = $config;
        $this->router        = $router;
        $this->dispatcher    = $dispatcher;
    }

    /**
     * @throws PithException|ReflectionException
     */
    public function start()
    {
        // Get the app
        $app = $this->app_retriever->getApp();

        // Load config
        $this->config->load();

        // User and session
        $app->active_user->start();

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

    /**
     * @param  string $route_namespace
     * @throws PithException
     * @throws ReflectionException
     */
    public function runRoute(string $route_namespace)
    {
        // Get route
        $route = $this->router->getRouteFromRouteNamespace($route_namespace);

        // Run route
        $this->dispatcher->dispatchRoute($route);
    }

    /**
     * @param  string $route_namespace
     * @throws PithException
     * @throws ReflectionException
     */
    public function runTaskRoute(string $route_namespace)
    {
        $this->runRoute($route_namespace);
    }


}