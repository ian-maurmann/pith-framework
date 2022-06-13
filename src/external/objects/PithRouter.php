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
use Pith\Framework\Internal\PithAppReferenceTrait;
use Pith\Framework\Internal\PithProblemHandler;
use Pith\Framework\Internal\PithRoute;
use Pith\Framework\Internal\PithStringUtility;
use ReflectionClass;
use ReflectionException;


/**
 * Class PithRouter
 * @package Pith\Framework
 */
class PithRouter implements PithRouterInterface
{
    use PithAppReferenceTrait;

    private $string_utility;
    private $problem_handler;
    private $route_object;

    public function __construct(PithStringUtility $string_utility, PithProblemHandler $problem_handler, PithRoute $route_object)
    {
        $this->string_utility  = $string_utility;
        $this->problem_handler = $problem_handler;
        $this->route_object    = $route_object;
    }


    // 0.6 implementation
    /**
     * @return string
     */
    public function whereAmI(): string
    {
        return 'Pith Router';
    }


    // 0.6 implementation
    /**
     * @return PithRoute
     * @throws ReflectionException
     *
     * @noinspection PhpUnused - Used by Pith Run Trait
     */
    public function routeByUrl(): PithRoute
    {
        $route_object = null;

        // Get the app route
        $app_route = $this->findAppRouteFromUrl();

        $route_object = $this->getRouteFromAppRoute($app_route);

        return $route_object;
    }


    // 0.6 implementation
    /**
     * @param $app_route_path
     * @return PithRoute
     * @throws ReflectionException
     *
     * @noinspection PhpUnused - Used by Pith Run Trait
     */
    public function routeByAppPath($app_route_path): PithRoute
    {

        $route_object = null;

        // Get the app route
        $app_route = $this->findAppRouteFromAppRoutePath($app_route_path);

        $route_object = $this->getRouteFromAppRoute($app_route);

        return $route_object;
    }


    // 0.6 implementation
    /**
     * @param $app_route
     * @return PithRoute
     * @throws ReflectionException
     */
    private function getRouteFromAppRoute($app_route): PithRoute
    {

        $route_object = null;

        // (On error, redirect to the 404 page)
        if (!$app_route) {
            $this->problem('Pith_Provisional_Notice_B5_000', $this->app->request_processor->getRequestPath());
        }


        $module_name_with_namespace = $app_route['module'];

        // Get the module
        $module = $this->app->container->get($module_name_with_namespace);


        // (On error, redirect to the 501 page)
        if (!$module) {
            $this->problem('Pith_Provisional_Error_B5_001', $app_route['match'], $module_name_with_namespace);
        }


        $module_reflector_object    = new ReflectionClass($module_name_with_namespace);
        $module_directory_full_path = dirname($module_reflector_object->getFileName());

        //echo $module_directory_full_path;


        // Get the route name
        $route_name = $app_route['route-name'];


        // Get the route
        $route = $this->findModuleRouteByRouteName($module, $route_name);


        // (On error, redirect to the 501 page)
        if (!$route) {
            $this->problem('Pith_Provisional_Error_B5_002', $app_route['route-name'], $app_route['module']);
        }


        $use_layout = (bool)$route['use-layout'];

        $layout_app_route_name = null;
        if ($use_layout) {
            if (!empty($app_route['layout'])) {
                $layout_app_route_name = $app_route['layout'];
            }
        }


        $view_relative_path = $route['view'];
        $view_full_path = $module_directory_full_path . '/' . $view_relative_path;

        $route_object = clone $this->route_object;

        $route_object->route_name                     = $route['route-name'];
        $route_object->route_type                     = $route['route-type'];
        $route_object->use_layout                     = $use_layout;
        $route_object->layout_app_route_name          = $layout_app_route_name;
        $route_object->controller_name_with_namespace = $route['controller'];
        $route_object->module_name_with_namespace     = $app_route['module'];
        $route_object->module_object                  = clone $module;
        $route_object->module_directory_full_path     = $module_directory_full_path;
        $route_object->view_relative_path             = $view_relative_path;
        $route_object->view_full_path                 = $view_full_path;

        return $route_object;
    }


    // 0.6 implementation
    /**
     * @return mixed|null
     *
     * @noinspection DuplicatedCode - Ignore
     */
    public function findAppRouteFromUrl()
    {
        $string_utility = $this->string_utility;
        $request_path   = (string)$this->app->request_processor->getRequestPath();
        $routes         = $this->app->config->getRouteList();
        $matching_route = null;

        foreach ($routes as $route_index => $route) {
            $match    = (string)$route['match'];
            $is_match = $string_utility->isRouteMatch($request_path, $match);

            if ($is_match) {
                $matching_route = $route;
                break;
            }
        }

        return $matching_route;
    }


    // 0.6 implementation
    /**
     * @param $app_route_path
     * @return mixed|null
     *
     * @noinspection DuplicatedCode - Ignore
     */
    public function findAppRouteFromAppRoutePath($app_route_path)
    {
        $string_utility = $this->string_utility;
        $request_path   = (string) $app_route_path;
        $routes         = $this->app->config->getRouteList();
        $matching_route = null;

        foreach ($routes as $route_index => $route) {
            $match    = (string) $route['match'];
            $is_match = $string_utility->isRouteMatch($request_path, $match);

            if ($is_match) {
                $matching_route = $route;
                break;
            }
        }

        return $matching_route;
    }


    // 0.6 implementation
    /**
     * @param $module
     * @param $given_route_name
     * @return mixed|null
     */
    public function findModuleRouteByRouteName($module, $given_route_name)
    {
        $routes         = $module->listRoutes();
        $matching_route = null;

        foreach ($routes as $route_name => $route) {
            if ((string) $route_name === (string) $given_route_name) {
                $matching_route = $route;
                break;
            }
        }

        return $matching_route;

    }


    // 0.6 implementation
    /**
     * @param $problem_name
     * @param ...$info
     */
    public function problem($problem_name, ...$info)
    {
        $this->problem_handler->handleProblem($problem_name, ...$info);
    }



    // 0.8 implementation

    /**
     * Route by URL
     *
     * @noinspection PhpVariableNamingConventionInspection - Ignore here.
     * @throws PithException
     */
    public function routeWithFastRoute(): array
    {
        $return_array = [];

        $fast_dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            // Get Routes
            $app_routes = $this->app->config->getRoutes();

            // Loop through routes, Add each route
            foreach ($app_routes as $app_route){
                $r->addRoute($app_route[0], $app_route[1], $app_route[2]);
            }
        });

        // Get HTTP method
        $httpMethod = $_SERVER['REQUEST_METHOD'];

        // Get URI
        $uri = $_SERVER['REQUEST_URI'];
        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

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

        // Debug
        // error_log('══════════════════════════════════════════════════' );
        // error_log('$httpMethod === ' . print_r($httpMethod, true));
        // error_log('$uri        === ' . print_r($uri, true));
        // error_log('$routeInfo  === ' . print_r($routeInfo, true));
        // error_log('══════════════════════════════════════════════════' );

        return $return_array;
    }



    // 0.8 implementation

    /**
     * @param  array $routing_info
     * @return null|\Pith\Framework\PithRoute
     * @throws PithException
     */
    private function getRouteObjectFromRouteInfo(array $routing_info): ?\Pith\Framework\PithRoute
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
     * @return null|\Pith\Framework\PithRoute
     * @throws PithException
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function getRouteFromRouteNamespace(string $route_namespace): ?\Pith\Framework\PithRoute
    {
        $route = null; // Default to null

        // Get the route object via the namespace
        try {
            $route = $this->app->container->get($route_namespace);
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


    // 0.8 implementation


    /**
     * @return \Pith\Framework\PithRoute|null
     * @throws PithException
     */
    public function getRoute(): ?\Pith\Framework\PithRoute
    {
        // Get the route info
        $routing_info = $this->routeWithFastRoute();
        $route        = $this->getRouteObjectFromRouteInfo($routing_info);
        $route_params = $routing_info['vars'];

        // Save route params
        $this->app->request->attributes->add(['route_parameters' => $route_params]);

        // Return the route object
        return $route;
    }

}