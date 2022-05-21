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
 * Pith Route (extend)
 * ---------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework;

use Pith\Framework\Internal\PithGetObjectClassDirectoryTrait;
use ReflectionException;

// ┌────────────────────────────────────────────────────────────────────────────┐
// │    PithRoute                                                               │
// ├────────────────────────────────────────────────────────────────────────────┤
// │    +  access_level : string            --- Name of access level            │
// │    +  action       : string            --- Namespace for action            │
// │    +  app          : PithApp reference --- Access to Pith App              │
// │    +  element_type : string 'route'    --- Name of workflow element        │
// │    +  layout       : string            --- Namespace for layout route      │
// │    +  preparer     : string            --- Namespace for preparer          │
// │    +  route_type   : string            --- Name of route type              │
// │    +  use_layout   : bool              --- Yes/No on adding layout to view │
// │    +  view         : string            --- Path to view                    │
// │    +  view_adapter : string            --- Namespace for view adapter      │
// ├────────────────────────────────────────────────────────────────────────────┤
// │    +  checkAccess( )    : void || throw exception                          │
// │    +  getAccessLevel( ) : string                                           │
// │    +  getAction( )      : PithAction                                       │
// │    +  getPreparer( )    : PithPreparer                                     │
// │    +  getViewAdapter( ) : object                                           │
// └────────────────────────────────────────────────────────────────────────────┘


/**
 * Class PithRoute
 * @package Pith\Framework
 */
class PithRoute extends PithWorkflowElement
{
    use PithGetObjectClassDirectoryTrait;

    public $access_level     = null;
    public $action           = null;
    public $element_type     = 'route';

    /**
     * @var string|null
     */
    public $layout           = null;

    public $pack             = null;
    public $preparer         = null;
    public $resource_folder  = null;
    public $route_type       = null;
    public $use_layout       = false;

    /**
     * @var string|null
     */
    public $view             = null;

    public $view_adapter     = null;

    /**
     * Holds the namespace for the View Requisition object
     * @var string|null
     */
    public $view_requisition = '\\Pith\\Framework\\Internal\\EmptyViewRequisition';



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
                $action = $this->app->container->get($action_namespace);
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
                $preparer = $this->app->container->get($preparer_namespace);
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
    public function getViewAdapter()
    {
        $view_adapter_namespace = (string) $this->view_adapter;
        $has_view_adapter       = (bool) strlen($view_adapter_namespace);

        if($has_view_adapter){
            try {
                $view_adapter = $this->app->container->get($view_adapter_namespace);
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
                $pack = $this->app->container->get($pack_namespace);
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
                $view_requisition = $this->app->container->get($view_requisition_namespace);
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
}