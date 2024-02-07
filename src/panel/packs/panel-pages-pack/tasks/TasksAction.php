<?php

/**
 * Tasks Action
 * ------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel\Pages;

use DI\DependencyException;
use DI\NotFoundException;
use Pith\Workflow\PithAction;
use Pith\Framework\PithDependencyInjection;

/**
 * Class TasksAction
 * @package Pith\Framework\Panel\Pages
 */
class TasksAction extends PithAction
{
    protected PithDependencyInjection $dependency_injection;

    public function __construct(PithDependencyInjection $dependency_injection)
    {
        // Set object dependencies
        $this->dependency_injection = $dependency_injection;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function runAction()
    {
        // Variables
        $tasks_route_list = $this->dependency_injection->container->get(TASKS_ROUTE_LIST);
        $task_routes      = $tasks_route_list->routes ?? [];

        // Push to Preparer
        $this->prepare->PITH_PANEL_PATH = PITH_PANEL_PATH;
        $this->prepare->TASKS_URL_PATH  = TASKS_URL_PATH;
        $this->prepare->task_routes     = $task_routes;
    }
}