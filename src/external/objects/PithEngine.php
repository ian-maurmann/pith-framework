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
        $this->routeByUrl();
    }

    /**
     * Route by URL
     *
     * @noinspection PhpVariableNamingConventionInspection - Ignore here.
     */
    public function routeByUrl()
    {

        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/users', 'get_all_users_handler');
            // {id} must be a number (\d+)
            $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
            // The /{title} suffix is optional
            $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
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

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found

                $this->handleFastRouteNotFound();
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed

                $this->handleFastRouteMethodNotAllowed($allowedMethods);
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                // ... call $handler with $vars

                $this->handleFastRouteFound($handler, $vars);
                break;
        }

        // Debug
        // error_log('══════════════════════════════════════════════════' );
        // error_log('$httpMethod === ' . print_r($httpMethod, true));
        // error_log('$uri        === ' . print_r($uri, true));
        // error_log('$routeInfo  === ' . print_r($routeInfo, true));
        // error_log('══════════════════════════════════════════════════' );
    }




    public function handleFastRouteNotFound()
    {
        // ... 404 Not Found

        error_log('Router: 404 Not Found');
    }

    public function handleFastRouteMethodNotAllowed($allowedMethods)
    {
        // ... 405 Method Not Allowed

        error_log('Router: 405 Method Not Allowed');
    }

    public function handleFastRouteFound($handler, $vars)
    {
        // ... call $handler with $vars

        error_log('Router: Found');
    }
}