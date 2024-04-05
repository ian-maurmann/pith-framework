<?php

/**
 * Tick task action
 * ----------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4, not PSR-0.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
 */

declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Tasks\Tick;

use DI\DependencyException;
use DI\NotFoundException;
use Pith\Framework\Base\ThinWrappers\PithDependencyInjection;
use Pith\Workflow\PithAction;
use Pith\Framework\PithAppRetriever;

use Pith\Framework\PithException;

/**
 * Class TickTaskAction
 * @package Pith\Framework\SharedInfrastructure\Tasks\Tick
 */
class TickTaskAction extends PithAction
{
    private PithAppRetriever $app_retriever;
    protected PithDependencyInjection $dependency_injection;

    public function __construct(PithAppRetriever $app_retriever, PithDependencyInjection $dependency_injection)
    {
        // Set object dependencies
        $this->app_retriever        = $app_retriever;
        $this->dependency_injection = $dependency_injection;
    }

    /**
     * @throws PithException
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function runAction()
    {
        // Get app
        $app = $this->app_retriever->getApp();
        $format = $app->cli_format;

        $app->cli_writer->writeLine($format->fg_bright_yellow . '╭────────╮' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '│  Tick  │' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '╰────────╯' . $format->reset);

        $workspace_list_items = $this->getWorkspaces();
        $has_run_heavy = false;
        foreach ($workspace_list_items as $workspace_list_item_index => $workspace_list_item){
            $workspace_name = $workspace_list_item[1];
            $workspace_namespace = $workspace_list_item[2];
            $orchestrator_namespace = $workspace_list_item[3];
            $has_orchestrator_namespace = !empty($orchestrator_namespace);


            if($has_orchestrator_namespace){
                $app->cli_writer->writeLine($format->fg_dark_yellow . '- Orchestrate ' . $format->fg_dark_cyan . $workspace_name . $format->reset);

                // Get Task Orchestrator
                $orchestrator = $this->dependency_injection->container->get($orchestrator_namespace);

                // Run Task Orchestrator
                $orchestration_info      = $orchestrator->orchestrate($has_run_heavy);
                $touchstones             = $orchestration_info['touchstones'];
                $did_run_task            = $orchestration_info['did_run_task'];
                $ran_task_name           = $orchestration_info['ran_task_name'];
                $was_heavy               = $orchestration_info['is_heavy'];
                $skipped_task_names      = $orchestration_info['skipped_task_names'];
                $number_of_tasks_skipped = count($skipped_task_names);
                $did_skip_tasks          = $number_of_tasks_skipped > 0;

                foreach ($touchstones as $touchstone){
                    $app->cli_writer->writeLine($format->fg_dark_yellow . '    - Looked at touchstone ' . $format->fg_dark_cyan . $touchstone . $format->fg_dark_yellow . '.' . $format->reset);
                }

                // Display skipped tasks
                if($did_skip_tasks){
                    foreach ($skipped_task_names as $skipped_task_name){
                        $app->cli_writer->writeLine($format->fg_dark_yellow . '    - Skipped ' . $format->fg_bright_yellow . $skipped_task_name . $format->fg_dark_yellow . '.' . $format->reset);
                    }
                }

                // Display task that was run
                if($did_run_task){
                    $app->cli_writer->writeLine($format->fg_dark_yellow . '    - Ran ' . $format->fg_bright_green . $ran_task_name . $format->reset);

                    if($was_heavy){
                        $app->cli_writer->writeLine($format->fg_dark_yellow . '    - ' . $format->fg_bright_yellow . 'Heavy' . $format->fg_dark_yellow . '.' . $format->reset);
                        $has_run_heavy = true;
                    }

                }
                else{
                    $app->cli_writer->writeLine($format->fg_dark_yellow . '    - ' . $format->fg_bright_yellow . 'No task ran' . $format->fg_dark_yellow . '.' . $format->reset);
                }



            }
            else{
                $app->cli_writer->writeLine($format->fg_dark_yellow . '- Skipping ' . $format->fg_dark_cyan . $workspace_name . $format->fg_dark_yellow . '.' . $format->reset);
            }
        }
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function getWorkspaces(): array
    {
        // Get app
        $workspaces_list_namespace = PITH_APP_TASK_WORKSPACES_LIST;
        $workspaces_list = $this->dependency_injection->container->get($workspaces_list_namespace);
        $workspaces = $workspaces_list->workspaces;

        return $workspaces;
    }

}