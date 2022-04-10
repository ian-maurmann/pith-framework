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
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework;

use Pith\Framework\Internal\PithAppReferenceTrait;

// ┌────────────────────────────────────────────────────────────────────────┐
// │    PithEngine                                                          │
// ├────────────────────────────────────────────────────────────────────────┤
// │    +  app : PithApp reference                                          │
// ├────────────────────────────────────────────────────────────────────────┤
// │    ~  __construct( ) : void                                            │
// │    +  whereAmI( )    : string                                          │
// └────────────────────────────────────────────────────────────────────────┘

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

    /**
     * @throws PithException
     */
    public function start()
    {
        $route = $this->app->router->getRoute();

        $this->engineDispatch($route);
    }



    /**
     * Engine Dispatch
     *
     * @param PithRoute $route
     * @param PithRoute|null $secondary_route
     *
     * @noinspection DuplicatedCode - Ignore
     * @throws PithException
     */
    public function engineDispatch(PithRoute $route, PithRoute $secondary_route=null)
    {
        if($route->route_type === 'layout'){
            $this->engineDispatchRoute($route, $secondary_route);
        }
        elseif($route->route_type === 'page' || $route->route_type === 'error-page'){
            if($route->use_layout){
                //$this->app->runLayout($route->layout_app_route_name, $route);
            }
            else{
                $this->engineDispatchRoute($route);
            }
        }
        elseif($route->route_type === 'partial'){
            $this->engineDispatchRoute($route);
        }

    }

    /**
     * @param PithRoute $route
     * @param PithRoute|null $secondary_route
     * @throws PithException
     */
    public function engineDispatchRoute(PithRoute $route, PithRoute $secondary_route=null)
    {
        echo '!!!!!!!!!';

        // ───────────────────────────────────────────────────────────────────────
        // ROUTE

        // Set app reference
        $route->setAppReference($this->app);


        // ───────────────────────────────────────────────────────────────────────
        // ACCESS

        // Check access
        $route->checkAccess();


        // ───────────────────────────────────────────────────────────────────────
        // ACTION

        // Get the action
        $action = $route->getAction();

        // Set app reference
        $action->setAppReference($this->app);

        // Provision action
        $action->provisionAction();

        // Start the output buffer
        //ob_start();

        // Run action
        $action->runAction();

        // Get variables for prepare
        $variables_for_prepare = $action->getVariablesForPrepare();


        // ───────────────────────────────────────────────────────────────────────
        // PREPARER

        // Get the preparer
        $preparer = $route->getPreparer();

        // Set app reference
        $preparer->setAppReference($this->app);

        // Provision preparer
        $preparer->provisionPreparer($variables_for_prepare);

        // Run preparer
        $preparer->runPreparer();

        // Get variables for prepare
        $variables_for_view = $preparer->getVariablesForView();

        // ───────────────────────────────────────────────────────────────────────
        // VIEW

        // Get the view adapter
        $view_adapter = $route->getViewAdapter();

        $view_adapter->setApp($this->app);
        $view_adapter->setFilePath($route->view);
        $view_adapter->setVars($variables_for_view);

        if(!empty($secondary_route)){
            $view_adapter->setIsLayout(true);
            $view_adapter->setContentRoute($secondary_route);
        }

        $view_adapter->run();

        // ───────────────────────────────────────────────────────────────────────



        // Flush the output buffer
        //ob_end_flush();
    }

}