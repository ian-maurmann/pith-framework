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
use Pith\Framework\Internal\PithDispatcherHelper;
use Pith\Framework\Internal\PithExpressionUtility;
use ReflectionException;


/**
 * Class PithDispatcher
 * @package Pith\Framework
 */
class PithDispatcher
{
    use PithAppReferenceTrait;

    private $helper;

    private $expression_utility;


    /**
     * @param PithDispatcherHelper  $helper
     * @param PithExpressionUtility $expression_utility
     */
    public function __construct(PithDispatcherHelper $helper, PithExpressionUtility $expression_utility)
    {
        $this->helper             = $helper;
        $this->expression_utility = $expression_utility;
    }



    /**
     * Engine Dispatch
     *
     * @param PithRoute $route
     * @param PithRoute|null $secondary_route
     * @throws PithException
     * @throws ReflectionException
     *
     * @noinspection DuplicatedCode - Ignore
     */
    public function engineDispatch(PithRoute $route, PithRoute $secondary_route=null)
    {
        switch ($route->route_type) {

            // Layout
            case 'layout':
                $this->engineDispatchRoute($route, $secondary_route);
                break;

            // Pages
            case 'error-page':
                // fall through
            case 'page':
                if($route->hasLayout()){
                    $layout_route = $this->app->router->getRouteFromRouteNamespace($route->layout);
                    $this->engineDispatch( $layout_route, $route);
                }
                else{
                    $this->engineDispatchRoute($route);
                }
                break;

            // Partials and Endpoints
            case 'endpoint':
                // fall through
            case 'partial':
                $this->engineDispatchRoute($route);
                break;

            // Resources
            case 'resource':
                $this->engineServeResource($route);
                break;
        }
    }



    /**
     * @param PithRoute $route
     * @param PithRoute|null $secondary_route
     * @throws PithException
     * @throws ReflectionException
     */
    public function engineDispatchRoute(PithRoute $route, PithRoute $secondary_route=null)
    {
        // ───────────────────────────────────────────────────────────────────────
        // ROUTE

        // Set app reference
        $route->setAppReference($this->app);

        // Set app reference for secondary route
        if($secondary_route){
            $secondary_route->setAppReference($this->app);
        }

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
        // VIEW REQUISITION

        // Get the view requisition
        $requisition = $route->getViewRequisition();

        // Dispatch requisition, set headers, get resources
        $resources = $this->dispatchViewRequisition($requisition);

        // If this is a layout
        if($secondary_route){
            // Get page requisition
            $secondary_requisition = $secondary_route->getViewRequisition();

            // Dispatch page requisition, set headers for page, get resources for page
            $secondary_resources = $this->dispatchViewRequisition($secondary_requisition);

            // Add new resources to resources array
            $resources = array_merge($resources, $secondary_resources);
        }



        // ───────────────────────────────────────────────────────────────────────
        // RESPONDER

        // Add resource files to responder
        $this->app->responder->addResourceFiles($resources);

        // If partial, insert resource files
        $is_partial = $route->route_type === 'partial' || $route->route_type === 'partial-route';
        if($is_partial){
            $this->app->responder->insertResourceFiles();
        }

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
        $view_adapter->setResources($resources);
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



    /**
     * @param  PithViewRequisition $requisition
     * @return array
     */
    public function dispatchViewRequisition(PithViewRequisition $requisition): array
    {
        // Set app reference
        $requisition->setAppReference($this->app);

        // Provision the requisition
        $requisition->provisionViewRequisition();

        // Run the requisition
        $requisition->runRequisition();

        // Get info from requisition
        $requisition_headers   = $requisition->getHeaders();
        $requisition_resources = $requisition->getResources();

        // Dispatch the headers
        $this->dispatchHeaders($requisition_headers);

        return $requisition_resources;
    }



    /**
     * @param array $headers
     *
     * @noinspection PhpSingleStatementWithBracesInspection - For readability.
     */
    public function dispatchHeaders(array $headers)
    {
        // Only if headers are not sent, so layouts and pages.
        // Partials never send headers when called inside a page or layout.
        if (!headers_sent()) {
            foreach ($headers as $header) {
                // Unpack header info
                $http_header   = $header['http_header'];
                $replace       = $header['replace'];
                $response_code = $header['response_code'];

                // Add header
                header($http_header, $replace, $response_code);
            }
        }
    }

    

    /**
     * @param PithRoute $route
     * @throws PithException
     * @throws ReflectionException
     *
     * @noinspection PhpIncludeInspection
     */
    public function engineServeResource(PithRoute $route)
    {
        // START - Copied from engineDispatchRoute() // TODO: Need to fix duplication later
        //------------

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


        //------------
        // END - Copied from engineDispatchRoute() // TODO: Need to fix duplication later


        // Get the relative Resource Folder path
        $resource_folder_expression = (string) $route->resource_folder;
        $resource_folder_path       = $this->expression_utility->getViewPathFromExpression($resource_folder_expression, $pack_folder, $route_folder);

        // Get the relative Filepath
        $route_parameters = $this->app->request->attributes->get('route_parameters');
        $request_filepath = (string) $route_parameters['filepath'];


        // Get the Real Resource Folder path
        $real_resource_folder_path = realpath(ltrim($resource_folder_path, '/'));


        // Check that the Real Resource Folder is a directory
        $is_real_resource_folder_path_a_folder = ($real_resource_folder_path && is_dir($real_resource_folder_path));
        if(!$is_real_resource_folder_path_a_folder){
            throw new PithException(
                'Pith Framework Exception 4021: Resource folder must be a folder.',
                4021
            );
        }


        // Get the Real Filepath
        $real_filepath = realpath(ltrim($resource_folder_path . $request_filepath, '/'));


        // Check that the Real Filepath is a file
        $is_real_filepath_a_file = ($real_filepath && is_file($real_filepath));
        if(!$is_real_filepath_a_file){
            throw new PithException(
                'Pith Framework Exception 4022: Resource file must be a file.',
                4022
            );
        }


        // Check that the Real Filepath is really inside the Real Resource Folder
        $is_real_filepath_inside_resource_folder = (strpos($real_filepath, $real_resource_folder_path . DIRECTORY_SEPARATOR) === 0);
        if(!$is_real_filepath_inside_resource_folder){
            throw new PithException(
                'Pith Framework Exception 4020: Requested Resource outside of Resource folder.',
                4020
            );
        }

        // Get the base name
        $basename = basename($real_filepath);

        // Don't serve dot files. Throw if dot file.
        $this->helper->ensureFilenameIsNotDotFile($basename, $real_filepath);

        // Get extension. Throw exception if it's a file type that shouldn't be a front-end resource.
        $file_extension = $this->helper->getResourceFileExtension($basename);

        // Set resource headers
        $this->helper->setResourceHeadersByExtension($real_filepath, $file_extension);


        // Serve file
        require $real_filepath;
    }

}



