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
 * Pith Config
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */

declare(strict_types=1);


namespace Pith\Framework;

use DI\DependencyException;
use DI\NotFoundException;
use Pith\Framework\Internal\PithAppReferenceTrait;

/**
 * Class PithConfig
 * @package Pith\Framework
 */
class PithConfig
{
    use PithAppReferenceTrait;

    /**
     * Holds path to the env constants file
     * @var string | null
     */
    public ?string $env_constants_file;

    /**
     * Holds path to the tracked constants file
     * @var string | null
     */
    public ?string $tracked_constants_file;

    /**
     * Holds the namespace of the Route List object
     * @var string | null
     */
    public ?string $route_list_namespace;

    /**
     * Holds route list object
     * @var PithRouteList | null
    */
    public ?PithRouteList $route_list;

    private PithDependencyInjection $dependency_injection;

    public function __construct(PithDependencyInjection $dependency_injection)
    {
        // Object Dependencies
        $this->dependency_injection = $dependency_injection;
    }

    /**
     * Get array of routes for FastRoute.
     * @return array
     */
    public function getRoutes(): array
    {
        // Default to empty array
        $routes = [];

        // Get the routes from the route list
        if($this->route_list){
            $routes = $this->route_list->routes;
        }

        // Return array of routes, or empty array on failure
        return $routes;
    }

    /**
     * @throws PithException
     *
     * @noinspection PhpIncludeInspection - The requires are ok here.
     */
    public function load()
    {
        // Load env constants
        require $this->env_constants_file;

        // Load tracked constants
        require $this->tracked_constants_file;

        // Add route list to config
        try {
            $this->route_list = $this->dependency_injection->container->get($this->route_list_namespace);
        } catch (DependencyException $exception) {
            throw new PithException(
                'Pith Framework Exception 5006: The container encountered a \DI\DependencyException exception. Message: ' . $exception->getMessage(),
                5006,
                $exception
            );
        } catch (NotFoundException $exception) {
            throw new PithException(
                'Pith Framework Exception 5007: The container encountered a \DI\NotFoundException exception. Message: ' . $exception->getMessage(),
                5007,
                $exception
            );
        }

        // Initialize the database's Username/Password/DSN from env constants
        $this->primeDatabase();
    }

    /**
     * Set Database Settings
     */
    public function primeDatabase()
    {
        $this->app->database->setDsn(PITH_APP_DATABASE_DSN);
        $this->app->database->setDbUserAndPassword(PITH_APP_DATABASE_USER_USERNAME, PITH_APP_DATABASE_USER_PASSWORD);
    }
}


