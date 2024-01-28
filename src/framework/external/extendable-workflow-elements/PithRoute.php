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
 * Pith Route (extend)
 * ---------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpCastIsUnnecessaryInspection        - Ignore for now. TODO
 */


declare(strict_types=1);


namespace Pith\Framework;

use Pith\Framework\Internal\PithGetObjectClassDirectoryTrait;
use ReflectionException;

// ┌────────────────────────────────────────────────────────────────────────────┐
// │    Route                                                                   │
// ├────────────────────────────────────────────────────────────────────────────┤
// │    +  access_level : string | namespace string                             │
// │    +  action : namespace string                                            │
// │    +  cache_level : string | http header string                            │
// │    #  dependency_injection : dependency injection object                   │
// │    +  element_type : string 'route'                                        │
// │    +  layout : namespace string                                            │
// │    +  meta_description : string                                            │
// │    +  meta_keywords : string                                               │
// │    +  meta_robots : string                                                 │
// │    +  pack : namespace string                                              │
// │    +  page_title : string                                                  │
// │    +  preparer : namespace string                                          │
// │    +  resource_folder : string expression                                  │
// │    +  resource_path : string expression                                    │
// │    +  route_type : string                                                  │
// │    +  view : string expression                                             │
// │    +  view_adapter : namespace string                                      │
// │    +  view_requisition : namespace string                                  │
// ├────────────────────────────────────────────────────────────────────────────┤
// │    +  getAccessLevel( ) : string | namespace string                        │
// │    +  getAction( ) : Action object                                         │
// │    +  getPack( ) : Pack object                                             │
// │    +  getPreparer( ) : Preparer object                                     │
// │    +  getRouteFolder( ) : string expression                                │
// │    +  getViewAdapter( ) : View Adapter object                              │
// │    +  getViewRequisition( ) : View Requisition object                      │
// │    +  hasLayout( ) : bool                                                  │
// │    +  setDependencyInjection( ) : void                                     │
// └────────────────────────────────────────────────────────────────────────────┘


/**
 * Class PithRoute
 * @package Pith\Framework
 */
class PithRoute extends PithWorkflowElement
{
    use PithGetObjectClassDirectoryTrait;

    /**
     * Holds the name of the access level, or namespace of an access level object
     * @var string
     */
    public string $access_level; // Default to null

    /**
     * Holds the namespace for the Action object
     * @var string
     */
    public string $action = '\\Pith\\Framework\\Internal\\EmptyAction'; // Use empty action as default

    /**
     * Holds the name of the cache level, or string for Header Cache-Control
     * @var string
     */
    public string $cache_level = ''; // Default to empty string

    /**
     * Holds the workflow element type as string
     * @var string
     */
    public string $element_type = 'route'; // Use string 'route'

    /**
     * Holds the namespace for the layout's route object, if has layout
     * @var string
     */
    public string $layout = ''; // Default to empty string

    /**
     * Holds the namespace for the Pack object
     * @var string
     */
    public string $pack;


    public string $preparer = '\\Pith\\Framework\\Internal\\PassThroughPreparer'; // Use the pass-through preparer as default

    /**
     * Holds string expression of the resource folder path
     * @var string
     */
    public string $resource_folder = '';

    /**
     * Holds expression of a single resource file path
     * @var string
     */
    public string $resource_path = '';

    /**
     * Specifies the type of route, for how the framework will handle it
     *
     * Possible values: 'layout', 'page', 'partial', 'error-page', 'endpoint', 'resource-file', 'resource-folder'
     * @var string
     */
    public string $route_type;

    public string $page_title = '';
    public string $meta_keywords = '';
    public string $meta_description = '';

    /**
     * Holds the meta content for the meta robots tag
     * @var string
     */
    public string $meta_robots = 'index, follow'; // Default to index, follow


    /**
     * Holds the filepath expression for the view file.
     *
     * ```
     * Start with [^pack_folder] to write the file path from folder the pack object is inside of.
     * Start with [^route_folder] to write the file path from the folder the route object is inside of.
     * ```
     *
     * @var string
     */
    public string $view = '';

    /**
     * Holds the namespace for the View Adapter object
     * @var string
     */
 // public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2'; // Use PithPhtmlViewAdapter2 as default
    public string $view_adapter = '\\Pith\\LatteViewAdapter\\PithLatteViewAdapter'; // Use the View Adapter for using Latte with Pith as the new default

    /**
     * Holds the namespace for the View Requisition object
     * @var string
     */
    public string $view_requisition = '\\Pith\\Framework\\Internal\\EmptyViewRequisition'; // Use empty view requisition as default



    /**
     * @return PithAction
     * @throws PithException
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection - Using namespace for DI exceptions here.
     */
    public function getAction(): PithAction
    {
        $action_namespace = (string) $this->action;
        $has_action       = (bool) strlen($action_namespace);

        if($has_action){
            try {
                $action = $this->dependency_injection->container->get($action_namespace);
            } catch (\DI\DependencyException $exception) {
                throw new PithException(
                    'Pith Framework Exception 4009: The container encountered a \DI\DependencyException exception loading the Action. Message: ' . $exception->getMessage(),
                    4009,
                    $exception
                );
            } catch (\DI\NotFoundException $exception) {
                throw new PithException(
                    'Pith Framework Exception 4010: The container encountered a \DI\NotFoundException exception loading the Action. Message: ' . $exception->getMessage(),
                    4010,
                    $exception
                );
            }
        }
        else{
            throw new PithException(
                'Pith Framework Exception 4008: Route does not have an Action.',
                4008
            );
        }

        return $action;
    }


    /**
     * @return PithPreparer
     * @throws PithException
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection - Using namespace for DI exceptions here.
     */
    public function getPreparer(): PithPreparer
    {
        $preparer_namespace = (string) $this->preparer;
        $has_preparer       = (bool) strlen($preparer_namespace);

        if($has_preparer){
            try {
                $preparer = $this->dependency_injection->container->get($preparer_namespace);
            } catch (\DI\DependencyException $exception) {
                throw new PithException(
                    'Pith Framework Exception 4012: The container encountered a \DI\DependencyException exception loading the Preparer. Message: ' . $exception->getMessage(),
                    4012,
                    $exception
                );
            } catch (\DI\NotFoundException $exception) {
                throw new PithException(
                    'Pith Framework Exception 4013: The container encountered a \DI\NotFoundException exception loading the Preparer. Message: ' . $exception->getMessage(),
                    4013,
                    $exception
                );
            }
        }
        else{
            throw new PithException(
                'Pith Framework Exception 4011: Route does not have a Preparer.',
                4011
            );
        }

        return $preparer;
    }


    /**
     * @return object
     * @throws PithException
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function getViewAdapter(): object
    {
        $view_adapter_namespace = (string) $this->view_adapter;
        $has_view_adapter       = (bool) strlen($view_adapter_namespace);

        if($has_view_adapter){
            try {
                $view_adapter = $this->dependency_injection->container->get($view_adapter_namespace);
            } catch (\DI\DependencyException $exception) {
                throw new PithException(
                    'Pith Framework Exception 4015: The container encountered a \DI\DependencyException exception loading the View Adapter. Message: ' . $exception->getMessage(),
                    4015,
                    $exception
                );
            } catch (\DI\NotFoundException $exception) {
                throw new PithException(
                    'Pith Framework Exception 4016: The container encountered a \DI\NotFoundException exception loading the View Adapter. Message: ' . $exception->getMessage(),
                    4016,
                    $exception
                );
            }
        }
        else{
            throw new PithException(
                'Pith Framework Exception 4014: Route does not have a View Adapter.',
                4014
            );
        }

        return $view_adapter;
    }


    /**
     * @return PithPack
     * @throws PithException
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection - Using namespace for DI exceptions here.
     */
    public function getPack(): PithPack
    {
        $pack_namespace = (string) $this->pack;
        $has_pack       = (bool) strlen($pack_namespace);

        if($has_pack){
            try {
                $pack = $this->dependency_injection->container->get($pack_namespace);
            } catch (\DI\DependencyException $exception) {
                throw new PithException(
                    'Pith Framework Exception 4018: The container encountered a \DI\DependencyException exception loading the Pack. Message: ' . $exception->getMessage(),
                    4018,
                    $exception
                );
            } catch (\DI\NotFoundException $exception) {
                throw new PithException(
                    'Pith Framework Exception 4019: The container encountered a \DI\NotFoundException exception loading the Pack. Message: ' . $exception->getMessage(),
                    4019,
                    $exception
                );
            }
        }
        else{
            throw new PithException(
                'Pith Framework Exception 4017: Route does not have a Pack.',
                4017
            );
        }

        return $pack;
    }



    /**
     * @return PithViewRequisition
     * @throws PithException
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection - Using namespace for DI exceptions here.
     */
    public function getViewRequisition(): PithViewRequisition
    {
        $view_requisition_namespace = (string) $this->view_requisition;
        $has_view_requisition       = (bool) strlen($view_requisition_namespace);

        if($has_view_requisition){
            try {
                $view_requisition = $this->dependency_injection->container->get($view_requisition_namespace);
            } catch (\DI\DependencyException $exception) {
                throw new PithException(
                    'Pith Framework Exception 4025: The container encountered a \DI\DependencyException exception loading the View Requisition. Message: ' . $exception->getMessage(),
                    4025,
                    $exception
                );
            } catch (\DI\NotFoundException $exception) {
                throw new PithException(
                    'Pith Framework Exception 4026: The container encountered a \DI\NotFoundException exception loading the View Requisition. Message: ' . $exception->getMessage(),
                    4026,
                    $exception
                );
            }
        }
        else{
            throw new PithException(
                'Pith Framework Exception 4024: Route does not have a View Requisition.',
                4024
            );
        }

        return $view_requisition;
    }


    /**
     * @return string
     * @throws ReflectionException
     */
    public function getRouteFolder(): string
    {
        return $this->getObjectClassDirectoryRelativePath();
    }

    /**
     * @return bool
     */
    public function hasLayout(): bool
    {
        return strlen($this->layout) > 0;
    }
}