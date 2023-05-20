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
 * Pith Router
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpUnusedLocalVariableInspection      - Setting default values is ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
 */


declare(strict_types=1);


namespace Pith\Framework;


use FastRoute;


/**
 * Class PithRouter
 * @package Pith\Framework
 */
class PithRouter
{
    private PithDependencyInjection $dependency_injection;
    private PithConfig              $config;
    private PithInboundRequest      $inbound_request;

    public function __construct(PithDependencyInjection $dependency_injection, PithConfig $config, PithInboundRequest $inbound_request)
    {
        // Object Dependencies
        $this->dependency_injection = $dependency_injection;
        $this->config               = $config;
        $this->inbound_request      = $inbound_request;
    }




    /**
     * @return PithRoute|null
     * @throws PithException
     */
    public function getRoute(): ?PithRoute
    {
        // Get route
        try{
            $routing_info = $this->routeWithFastRoute();
        } catch (PithException $pith_exception) {
            if($pith_exception->getCode() === 4004){

                // Set headers for 404
                http_response_code(404);

                // 404 error page
                $routing_info = $this->routeWithFastRoute('/error-404');
            }
            else{
                throw $pith_exception;
            }

        }




        // Get route info
        $route        = $this->getRouteObjectFromRouteInfo($routing_info);
        $route_params = $routing_info['vars'];

        // Save route params
        $this->inbound_request->request->attributes->add(['route_parameters' => $route_params]);

        // Return the route object
        return $route;
    }


    /**
     * Route by URL
     *
     * @noinspection PhpVariableNamingConventionInspection - Ignore here.
     * @param string|null $uri
     * @return array
     * @throws PithException
     */
    public function routeWithFastRoute(string|null $uri = null): array
    {
        $return_array = [];

        $fast_dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            // Get Routes
            $app_routes = $this->config->getRoutes();
            
            // Loop through routes, Add each route
            foreach ($app_routes as $app_route){
                if($app_route[0] === 'route'){
                    $r->addRoute($app_route[1], $app_route[2], $app_route[3]);
                }
            }
        });

        // Get HTTP method
        $httpMethod = $_SERVER['REQUEST_METHOD'];

        // Get URI
        $uri = ($uri !== null) ? $uri : $this->getUri();

        $routeInfo = $fast_dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                // error_log('Router: 404 Not Found');

                throw new PithException(
                    'Pith Framework Exception 4004: Route not found. FastRoute\Dispatcher::NOT_FOUND',
                    4004
                );
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                // error_log('Router: 405 Method Not Allowed');

                throw new PithException(
                    'Pith Framework Exception 4005: Route not found. FastRoute\Dispatcher::NOT_FOUND. Allowed Methods: ' . $allowedMethods,
                    4005
                );
            case FastRoute\Dispatcher::FOUND:
                // error_log('Router: Found');

                $handler = $routeInfo[1];
                $vars    = $routeInfo[2];

                $return_array = [
                    'http_method' => $httpMethod,
                    'uri'         => $uri,
                    'handler'     => $handler,
                    'vars'        => $vars,
                ];

                break;
        }

        return $return_array;
    }



    /**
     * @param  array $routing_info
     * @return null|PithRoute
     * @throws PithException
     */
    private function getRouteObjectFromRouteInfo(array $routing_info): ?PithRoute
    {
        $route        = null;
        $did_routing  = (bool) count($routing_info);

        if($did_routing){
            $route_namespace = $routing_info['handler'];
            $route           = $this->getRouteFromRouteNamespace($route_namespace);
        }
        else{
            throw new PithException(
                'Pith Framework Exception 5003: Router returned empty routing array.',
                5003
            );
        }

        return $route;
    }



    /**
     * @param  string $route_namespace
     * @return null|PithRoute
     * @throws PithException
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function getRouteFromRouteNamespace(string $route_namespace): ?PithRoute
    {
        $route = null; // Default to null

        // Get the route object via the namespace
        try {
            $route = $this->dependency_injection->container->get($route_namespace);
        } catch (\DI\DependencyException $exception) {
            throw new PithException(
                'Pith Framework Exception 5004: The container encountered a \DI\DependencyException exception loading route. Message: ' . $exception->getMessage(),
                5004,
                $exception
            );
        } catch (\DI\NotFoundException $exception) {
            throw new PithException(
                'Pith Framework Exception 5005: The container encountered a \DI\NotFoundException exception loading route. Message: ' . $exception->getMessage(),
                5005,
                $exception
            );
        }

        return $route;
    }



    private function getUri(): string
    {
        // Get URI
        $uri = $_SERVER['REQUEST_URI'];
        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        // Return the URI
        return $uri;
    }


}