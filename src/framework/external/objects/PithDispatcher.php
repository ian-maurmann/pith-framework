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
 * Pith Dispatcher
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection      - Short property names are ok.
 * @noinspection PhpVariableNamingConventionInspection      - Short variable names are ok.
 * @noinspection PhpMethodNamingConventionInspection        - Long method names are ok.
 * @noinspection PhpArrayShapeAttributeCanBeAddedInspection - Ignore, array shapes are not set in stone yet.
 * @noinspection PhpTooManyParametersInspection             - Methods with a long list of parameters are ok here.
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

    // Helper
    private PithDispatcherHelper $helper;

    // Objects
    private PithExpressionUtility $expression_utility;


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
     * @param PithRoute $route
     * @param PithRoute|null $secondary_route
     * @throws PithException
     * @throws ReflectionException
     */
    public function dispatch(PithRoute $route, PithRoute|null $secondary_route=null)
    {
        switch ($route->route_type) {

            // Layout
            case 'layout':
                $this->dispatchRoute($route, $secondary_route);
                break;

            // Pages
            case 'error-page':
                // fall through
            case 'page':
                if($route->hasLayout()){
                    $layout_route = $this->app->router->getRouteFromRouteNamespace($route->layout);
                    $this->tapMetadata($route);
                    $this->dispatch( $layout_route, $route);
                }
                else{
                    $this->dispatchRoute($route);
                }
                break;

            // Partials and Endpoints
            case 'endpoint':
                // fall through
            case 'partial':
                $this->dispatchRoute($route);
                break;

            // Resources
            case 'resource':
                try{
                    $this->dispatchResource($route);
                } catch (PithException $pith_exception) {
                    // Set headers for 404
                    http_response_code(404);
                }
                break;
            // Single Resource
            case 'single-resource':
                try{
                    $this->dispatchSingleResource($route);
                } catch (PithException $pith_exception) {
                    // Set headers for 404
                    http_response_code(404);
                }
                break;
        }
    }



    /**
     * @param PithRoute $route
     * @param PithRoute|null $secondary_route
     * @throws PithException
     * @throws ReflectionException
     */
    public function dispatchRoute(PithRoute $route, PithRoute|null $secondary_route=null)
    {
        // ROUTE
        // Tap on the Route (and secondary Route)
        $route_info   = $this->tapRoute($route, $secondary_route);
        $route_folder = $route_info['route_folder'];

        // PACK
        // Tap on the Pack
        $pack_info   = $this->tapPack($route);
        $pack_folder = $pack_info['pack_folder'];

        // ACCESS
        // Tap on the Access Level
        $this->tapAccess($route);

        // ACTION
        // Tap on the Action
        $action_info           = $this->tapAction($route);
        $variables_for_prepare = $action_info['variables_for_prepare'];

        // PREPARER
        // Tap on the Preparer
        $preparer_info      = $this->tapPreparer($route, $variables_for_prepare);
        $variables_for_view = $preparer_info['variables_for_view'];

        // VIEW REQUISITION
        // Tap on the View Requisition
        $requisition_info = $this->tapViewRequisition($route, $secondary_route);
        $resources        = $requisition_info['resources'];

        // RESPONDER
        // Tap on the Responder
        $this->tapResponder($route,  $resources);

        // VIEW
        // Tap on the View
        $this->tapView($route, $secondary_route, $pack_folder, $route_folder, $resources, $variables_for_view);
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
    public function dispatchResource(PithRoute $route)
    {
        // ROUTE
        // Tap on the Route
        $route_info   = $this->tapRoute($route);
        $route_folder = $route_info['route_folder'];

        // PACK
        // Tap on the Pack
        $pack_info   = $this->tapPack($route);
        $pack_folder = $pack_info['pack_folder'];

        // ACCESS
        // Tap on the Access Level
        $this->tapAccess($route);

        // Get the relative Resource Folder path
        $resource_folder_expression = (string) $route->resource_folder;
        $resource_folder_path       = $this->expression_utility->getViewPathFromExpression($resource_folder_expression, $pack_folder, $route_folder);

        // Get the relative Filepath
        $route_parameters = $this->app->request->attributes->get('route_parameters');
        $request_filepath = (string) $route_parameters['filepath'];

        // Get the Real Resource Folder path
        $real_resource_folder_path = realpath(ltrim($resource_folder_path, '/'));

        // Check that the Real Resource Folder is a directory
        $this->helper->ensureRealResourceFolderIsADirectory($real_resource_folder_path);

        // Get the Real Filepath
        $real_filepath = realpath(ltrim($resource_folder_path . $request_filepath, '/'));

        // Check that the Real Filepath is a file
        $this->helper->ensureRealFilepathIsAFile($real_filepath);

        // Check that the Real Filepath is really inside the Real Resource Folder
        $this->helper->ensureRealFilepathIsInsideRealResourceFolder($real_filepath, $real_resource_folder_path);

        // Get the base name
        $basename = basename($real_filepath);

        // Don't serve dot files. Throw if dot file.
        $this->helper->ensureFilenameIsNotDotFile($basename, $real_filepath);

        // Get extension. Throw exception if it's a file type that shouldn't be a front-end resource.
        $file_extension = $this->helper->getResourceFileExtension($basename);

        // Set resource-type headers
        $this->helper->setResourceHeadersByExtension($real_filepath, $file_extension);

        // Set caching headers
        $this->helper->setCachingHeaders($route);

        // Serve file
        require $real_filepath;
    }

    /**
     * @param PithRoute $route
     * @throws PithException
     * @throws ReflectionException
     *
     * @noinspection PhpIncludeInspection
     */
    public function dispatchSingleResource(PithRoute $route)
    {
        // ROUTE
        // Tap on the Route
        $route_info   = $this->tapRoute($route);
        $route_folder = $route_info['route_folder'];

        // PACK
        // Tap on the Pack
        $pack_info   = $this->tapPack($route);
        $pack_folder = $pack_info['pack_folder'];

        // ACCESS
        // Tap on the Access Level
        $this->tapAccess($route);

        // Get the relative Resource Folder path
        // $resource_folder_expression = (string) $route->resource_folder;
        // $resource_folder_path       = $this->expression_utility->getViewPathFromExpression($resource_folder_expression, $pack_folder, $route_folder);

        // Get the relative Resource path
        $resource_path_expression = (string) $route->resource_path;
        $resource_file_path       = $this->expression_utility->getViewPathFromExpression($resource_path_expression, $pack_folder, $route_folder);

        // Get the relative Filepath
        // $route_parameters = $this->app->request->attributes->get('route_parameters');
        // $request_filepath = (string) $route_parameters['filepath'];

        // Get the Real Resource Folder path
        // $real_resource_folder_path = realpath(ltrim($resource_folder_path, '/'));

        // Check that the Real Resource Folder is a directory
        // $this->helper->ensureRealResourceFolderIsADirectory($real_resource_folder_path);

        // Get the Real Filepath
        //$real_filepath = realpath(ltrim($resource_folder_path . $request_filepath, '/'));
        $real_filepath = realpath(ltrim($resource_file_path, '/'));

        // Check that the Real Filepath is a file
        $this->helper->ensureRealFilepathIsAFile($real_filepath);

        // Check that the Real Filepath is really inside the Real Resource Folder
        //$this->helper->ensureRealFilepathIsInsideRealResourceFolder($real_filepath, $real_resource_folder_path);

        // Get the base name
        $basename = basename($real_filepath);

        // Don't serve dot files. Throw if dot file.
        $this->helper->ensureFilenameIsNotDotFile($basename, $real_filepath);

        // Get extension. Throw exception if it's a file type that shouldn't be a front-end resource.
        // $file_extension = $this->helper->getResourceFileExtension($basename);
        $file_extension = pathinfo($basename, PATHINFO_EXTENSION);

        // Set resource-type headers
        $this->helper->setResourceHeadersByExtension($real_filepath, $file_extension);

        // Set caching headers
        $this->helper->setCachingHeaders($route);

        // Serve file
        require $real_filepath;
    }



    /**
     * @param PithRoute $route
     * @param PithRoute|null $secondary_route
     * @return array
     * @throws ReflectionException
     */
    protected function tapRoute(PithRoute $route, PithRoute|null $secondary_route=null): array
    {
        // ROUTE
        // ─────

        // Set app reference
        $route->setAppReference($this->app);

        // Set app reference for secondary route
        if($secondary_route){
            $secondary_route->setAppReference($this->app);
        }

        // Get route folder
        $route_folder = $route->getRouteFolder();

        // Return variables needed to continue dispatching
        return [
            'route_folder' => $route_folder
        ];
    }


    /**
     * @param PithRoute $route
     * @return array
     * @throws PithException
     * @throws ReflectionException
     */
    protected function tapPack(PithRoute $route): array
    {
        // PACK
        // ────

        // Get the pack
        $pack = $route->getPack();

        // Set app reference
        $pack->setAppReference($this->app);

        // Get pack folder
        $pack_folder = $pack->getPackFolder();

        // Return variables needed to continue dispatching
        return[
            'pack_folder' => $pack_folder
        ];
    }

    /**
     * @param PithRoute $route
     * @return array
     * @throws PithException
     */
    protected function tapAccess(PithRoute $route): array
    {
        // ACCESS
        // ──────

        // Check access
        $route->checkAccess();

        // Return variables needed to continue dispatching
        return [];
    }

    /**
     * @param PithRoute $route
     * @return array
     * @throws PithException
     */
    protected function tapAction(PithRoute $route): array
    {
        // ACTION
        // ──────

        // Get the action
        $action = $route->getAction();

        // Set app reference
        $action->setAppReference($this->app);

        // Provision action
        $action->provisionAction();

        // Run action
        $action->runAction();

        // Get variables for prepare
        $variables_for_prepare = $action->getVariablesForPrepare();

        // Return variables needed to continue dispatching
        return [
            'variables_for_prepare' => $variables_for_prepare
        ];
    }

    /**
     * @param PithRoute $route
     * @param object $variables_for_prepare
     * @return array
     * @throws PithException
     */
    protected function tapPreparer(PithRoute $route, object $variables_for_prepare): array
    {
        // PREPARER
        // ────────

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

        return [
            'variables_for_view' => $variables_for_view
        ];
    }

    /**
     * @param PithRoute $route
     * @param PithRoute|null $secondary_route
     * @return array
     * @throws PithException
     */
    protected function tapViewRequisition(PithRoute $route, PithRoute|null $secondary_route=null): array
    {
        // VIEW REQUISITION
        // ────────────────

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

        return [
            'resources' => $resources
        ];
    }


    /**
     * @param PithRoute $route
     * @param array $resources
     */
    public function tapResponder(PithRoute $route, array $resources)
    {
        // RESPONDER
        // ─────────

        // Add resource files to responder
        $this->app->responder->addResourceFiles($resources);

        // If partial, insert resource files
        $is_partial = $route->route_type === 'partial' || $route->route_type === 'partial-route';
        if($is_partial){
            $this->app->responder->insertResourceFiles();
        }
    }


    /**
     * @param PithRoute $route
     */
    protected function tapMetadata(PithRoute $route)
    {
        // METADATA
        // ────────

        // Set metadata
        $this->app->responder->setPageMetadata($route->page_title, $route->meta_keywords, $route->meta_description, $route->meta_robots);
    }


    /**
     * @param PithRoute $route
     * @param PithRoute|null $secondary_route
     * @param string $pack_folder
     * @param string $route_folder
     * @param array $resources
     * @param object $variables_for_view
     * @throws PithException
     */
    protected function tapView(PithRoute $route, PithRoute|null $secondary_route, string $pack_folder, string $route_folder, array $resources, object $variables_for_view)
    {
        // VIEW
        // ────

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
    }

}



