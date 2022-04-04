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
 * Pith Engine
 * -----------
 *
 * @noinspection PhpMethodNamingConventionInspection - Long method names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework;

use Pith\Framework\Internal\PithAppReferenceTrait;
use FastRoute;


/**
 * Class PithEngine
 * @package Pith\Framework
 */
class PithEngine
{
    use PithAppReferenceTrait;

    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     * @return string
     */
    public function whereAmI(): string
    {
        return 'Pith Engine object';
    }

    public function start()
    {
        $routing_info = $this->routeByUrl();

        echo $routing_info['handler'];
    }

    /**
     * Route by URL
     *
     * @noinspection PhpVariableNamingConventionInspection - Ignore here.
     */
    public function routeByUrl(): array
    {
        $return_array = [];

        $fast_dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            // Get Routes
            $app_routes = APP_ROUTES;

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

}