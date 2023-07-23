<?php

/**
 * Tasks view-requisition
 * ----------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel\Pages;

use Pith\Framework\PithViewRequisition;

/**
 * Class TasksViewRequisition
 * @package Pith\Framework\Panel\Pages
 */
class TasksViewRequisition extends PithViewRequisition
{
    public string $requisition_type = 'view-requisition';

    public function runRequisition()
    {
        // App CSS for page
        $this->addStylesheet('Panel Task-Control stylesheet', PITH_PANEL_PATH . '/resources/feature/task-control/panel-task-control.css', 'application-for-page');

        // App JS for page
        $this->addScript('Panel Task-Control script', PITH_PANEL_PATH . '/resources/feature/task-control/panel-task-control.js', 'application-for-page');
    }
}