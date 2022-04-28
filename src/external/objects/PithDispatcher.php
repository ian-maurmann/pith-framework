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
 * Pith Dispatcher
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework;

use Pith\Framework\Internal\PithAppReferenceTrait;
use Pith\Framework\Internal\PithExpressionUtility;
use Pith\Framework\Internal\PithStringUtility;
use Pith\Framework\Internal\PithProblemHandler;



/**
 * Class PithDispatcher
 * @package Pith\Framework
 */
class PithDispatcher
{
    use PithAppReferenceTrait;

    private $expression_utility;
    private $string_utility;
    private $problem_handler;


    /**
     * @param PithExpressionUtility $expression_utility
     * @param PithStringUtility     $string_utility
     * @param PithProblemHandler    $problem_handler
     */
    public function __construct(PithExpressionUtility $expression_utility, PithStringUtility $string_utility, PithProblemHandler $problem_handler)
    {
        $this->expression_utility = $expression_utility;
        $this->string_utility     = $string_utility;
        $this->problem_handler    = $problem_handler;
    }

    // 0.6
    /**
     * @return string
     * @noinspection PhpMissingReturnTypeInspection - Ignore for now.
     */
    public function whereAmI()
    {
        return 'Pith Dispatcher';
    }


    // 0.6
    /**
     * @param $route
     * @param null $secondary_route
     */
    public function dispatch($route, $secondary_route=null)
    {
        if($route->route_type === 'layout'){
            $this->dispatch_route($route, $secondary_route);
        }
        elseif($route->route_type === 'page' || $route->route_type === 'error-page'){
            if($route->use_layout){
                $this->app->runLayout($route->layout_app_route_name, $route);
            }
            else{
                $this->dispatch_route($route);
            }
        }
        elseif($route->route_type === 'partial'){
            $this->dispatch_route($route);
        }

    }

    // 0.6
    /**
     * @param $route
     * @param $secondary_route
     *
     * @noinspection PhpMethodNamingConventionInspection  - Ignore for now.
     * @noinspection PhpUndefinedMethodInspection         - Ignore.
     * @noinspection PhpFullyQualifiedNameUsageInspection - Ignore for now.
     */
    public function dispatch_route($route, $secondary_route=null)
    {
        // Start the output buffer
        ob_start();



//        echo '<hr/>';
//        echo '<h3>Route</h3>';
//        echo '<pre><code>';
//        var_dump($route);
//        echo '</code></pre>';



        // Get the controller
        $controller = false;
        try {
            $controller = $this->app->container->get($route->controller_name_with_namespace);
        }
        catch (\DI\NotFoundException $e) {
            $this->app->problem('Pith_Provisional_Error_B6_000', $route->route_name, $route->controller_name_with_namespace);
        }


        
        //echo $controller->whereAmI();


        //-----------------------------------------------

        // Run Access
        $controller->access();


        // Get the access level
        $access_level_name = $controller->getAccessLevel();


        // Clear the access level
        $controller->resetAccessLevel();


        // TODO: process the access here

        $is_allowed = $this->app->access_control->isAllowedToAccess($access_level_name);

        if(!$is_allowed){
            // If not logged in:
            $this->app->problem('Pith_Provisional_Error_C3_000', $route->route_name, $route->controller_name_with_namespace, $access_level_name);

            // If logged in: // TODO
            // Pith_Provisional_Error_C3_001 // TODO
        }

//        echo '<hr/>';
//
//        echo '<h3>Access Level</h3>';
//        echo '<pre><code>';
//        var_dump($access_level_name);
//        echo '</code></pre>';
//
//        echo '<h3>Is Allowed</h3>';
//        echo '<pre><code>';
//        var_dump($is_allowed);
//        echo '</code></pre>';




        //-----------------------------------------------



        // Run Injector
        $controller->injector($this->app);


        // Get the Injector's "inject"
        $inject = $controller->getInject();


        // Clear the Injector's "inject"
        $controller->resetInject();



//        echo '<hr/>';
//        echo '<h3>Inject</h3>';
//        echo '<pre><code>';
//        var_dump($inject);
//        echo '</code></pre>';



        //-----------------------------------------------







        // Run Action
        $controller->action($this->app, $inject);


        // Get the Actions's "prepare"
        $prepare = $controller->getPrepare();


        // Clear the Action's "prepare"
        $controller->resetPrepare();



//        echo '<hr/>';
//        echo '<h3>Action</h3>';
//        echo '<pre><code>';
//        var_dump($prepare);
//        echo '</code></pre>';





        //-----------------------------------------------






        // Run Preparer
        $controller->preparer($this->app, $prepare);


        // Get the Preparer's "view"
        $view = $controller->getView();


        // - - - - - - - - - - - -

        $view_adapter = $controller->getViewAdapter();


        // - - - - - - - - - - - -


        // Clear the Preparer's "view"
        $controller->resetView();



//         echo '<hr/>';
//         echo '<h3>Preparer</h3>';
//         echo '<pre><code>';
//         var_dump($view);
//         echo '</code></pre>';





        //-----------------------------------------------


        // - - - - - - - - - - - -

        $view_full_path = $route->view_full_path;

        $view_adapter->setApp($this->app);
        $view_adapter->setFilePath($view_full_path);
        $view_adapter->setVars($view);

        if(!empty($secondary_route)){
            $view_adapter->setIsLayout(true);
            $view_adapter->setContentRoute($secondary_route);
        }

        $view_adapter->run();

        // - - - - - - - - - - - -




        // Flush the output buffer
        ob_end_flush();
    }



    // 0.8


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
                $layout_route = $this->app->router->getRouteFromRouteNamespace($route->layout);
                $this->engineDispatch( $layout_route, $route);
            }
            else{
                $this->engineDispatchRoute($route);
            }
        }
        elseif($route->route_type === 'partial' || 'endpoint'){
            $this->engineDispatchRoute($route);
        }

    }



    // 0.8

    /**
     * @param PithRoute $route
     * @param PithRoute|null $secondary_route
     * @throws PithException
     */
    public function engineDispatchRoute(PithRoute $route, PithRoute $secondary_route=null)
    {
        // ───────────────────────────────────────────────────────────────────────
        // ROUTE

        // Set app reference
        $route->setAppReference($this->app);

        // Get route folder
        $route_folder = $route->getRouteFolder();


        // ───────────────────────────────────────────────────────────────────────
        // PACK

        // Get the pack
        $pack = $route->getPack();

        // Set app reference
        $pack->setAppReference($this->app);

        // Get pack folder
        $pack_folder = $pack->getPackFolder();

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

        // Get output buffer
        // $action_output_buffer = ob_get_contents();

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

        // Get output buffer
        // $preparer_output_buffer = ob_get_contents();

        // Get variables for prepare
        $variables_for_view = $preparer->getVariablesForView();

        // ───────────────────────────────────────────────────────────────────────
        // VIEW



        // Get the view expression
        $view_expression = $route->view;

        // Get the view filepath
        $view_path = $this->expression_utility->getViewPathFromExpression($view_expression, $pack_folder, $route_folder);

        // Get the view adapter
        $view_adapter = $route->getViewAdapter();

        // Provision the view adapter
        $view_adapter->setApp($this->app);
        $view_adapter->setFilePath($view_path);
        $view_adapter->setVars($variables_for_view);

        if(!empty($secondary_route)){
            $view_adapter->setIsLayout(true);
            $view_adapter->setContentRoute($secondary_route);
        }

        // Tell the view adapter to run the view
        $view_adapter->run();

        // ───────────────────────────────────────────────────────────────────────



        // Flush the output buffer
        //ob_end_flush();
    }


}



