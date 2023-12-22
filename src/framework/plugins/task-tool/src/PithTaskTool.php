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
 * Pith Task Tool
 * ---------------
 *
 */

declare(strict_types=1);


namespace Pith\TaskTool;

use DI\Container;
use Exception;
use Pith\Framework\Internal\PithArrayUtility;
use Pith\Framework\Internal\PithTaskLogger;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithCliFormat;
use Pith\Framework\PithCliWriter;
use Pith\Framework\PithException;
use Pith\Framework\PithInfo;


class PithTaskTool
{
    private PithAppRetriever $app_retriever;
    private PithArrayUtility $array_utility;
    private PithCliFormat    $cli_format;
    private PithCliWriter    $cli_writer;
    private Container        $container;
    private PithInfo         $info;
    private PithTaskLogger   $task_logger;

    public function __construct()
    {
        // Add objects
        $this->container     = new Container();
        $this->app_retriever = $this->container->get('Pith\\Framework\\PithAppRetriever');
        $this->array_utility = $this->container->get('Pith\\Framework\\Internal\\PithArrayUtility');
        $this->cli_format    = $this->container->get('Pith\\Framework\\PithCliFormat');
        $this->cli_writer    = $this->container->get('Pith\\Framework\\PithCliWriter');
        $this->info          = $this->container->get('Pith\\Framework\\PithInfo');
        $this->task_logger   = $this->container->get('Pith\\Framework\\Internal\\PithTaskLogger');
    }

    public function displayAboutTask($given_workspace_name, $given_task_name)
    {
        $writer = $this->cli_writer;
        $format = $this->cli_format;

        $workspaces = $this->getWorkspaces();
        foreach ($workspaces as $workspace){
            $workspace_name = $workspace[1];
            $is_workspace_name_a_match = $workspace_name === $given_workspace_name;
            if($is_workspace_name_a_match){
                $workspace_namespace = $workspace[2];
                $tasks = $this->getWorkspaceTasks($workspace_namespace);

                //$writer->writeLine('    ' . $format->fg_dark_yellow . $workspace_name . $format->reset . ' workspace:');
                foreach($tasks as $task){
                    $task_listing_type = $task[0];
                    $task_name = $task[1];
                    $task_description = $task[2];
                    $task_route_namespace = $task[3];
                    //$writer->writeLine('        ' . $task_listing_type . ' ' . $format->fg_bright_green . $task_name . $format->reset . ' - ' . $task_description);

                    $is_task_name_a_match = $task_name === $given_task_name;
                    if($is_task_name_a_match){
                        $route = $this->container->get($task_route_namespace);
                        $access_level = $route->access_level ?? '';
                        $action = $route->action ?? '';
                        $preparer = $route->preparer ?? '';
                        $view_requisition = $route->view_requisition ?? '';
                        $view = $route->view ?? '';
                        $view_adapter = $route->view_adapter ?? '';
                        break;
                    }
                }
                break;
            }
        }

        $writer->writeLine('Task Info:');
        $writer->writeLine('    Workspace Name: ' . $format->fg_bright_cyan . $given_workspace_name . $format->reset);
        $writer->writeLine('    Task Name: ' . $format->fg_bright_cyan . $given_task_name . $format->reset);
        $writer->writeLine('    Task Type: ' . $format->fg_bright_cyan . $task_listing_type . $format->reset);
        $writer->writeLine('    Task Description: ' . $format->fg_bright_cyan . $task_description . $format->reset);
        $writer->writeLine('    Route: ' . $format->fg_bright_cyan . $task_route_namespace . $format->reset);
        $writer->writeLine('    Access Level: ' . $format->fg_bright_cyan . $access_level . $format->reset);
        $writer->writeLine('    Action: ' . $format->fg_bright_cyan . $action . $format->reset);
        $writer->writeLine('    Preparer: ' . $format->fg_bright_cyan . $preparer . $format->reset);
        $writer->writeLine('    View Requisition: ' . $format->fg_bright_cyan . $view_requisition . $format->reset);
        $writer->writeLine('    View: ' . $format->fg_bright_cyan . $view . $format->reset);
        $writer->writeLine('    View Adaptor: ' . $format->fg_bright_cyan . $view_adapter . $format->reset);


        $workspaces = $this->getWorkspaces();
    }



    public function displayInfo()
    {
        $writer = $this->cli_writer;
        $format = $this->cli_format;

     // $writer->writeLine($format->bg_dark_black . $format->fg_bright_yellow);
        $writer->writeLine('Pith Task Tool');
        $writer->writeLine('    ' . 'Tool for running commands from the command line.');
        $writer->writeLine('    ');
        $writer->writeLine('    ' . '╭────────────────────────────────────────────────────────╮');
        $writer->writeLine('    ' . '  ' . $this->info->getVersionSlug());
        $writer->writeLine('    ' . '  ' .'Released under license: ' . $this->info->getLicenseName());
        $writer->writeLine('    ' . '  ' .$this->info->getCopyrightNotice());
        $writer->writeLine('    ' . '╰────────────────────────────────────────────────────────╯');
        $writer->writeLine('    ');
        $writer->writeLine('    ' . '- Thanks!');
        $writer->writeLine('    ' . '- Ian M.');
        $writer->writeLine($format->reset);
    }

    public function displayList()
    {
        $writer = $this->cli_writer;
        $format = $this->cli_format;

        $writer->writeLine('Task List:');

        $workspaces = $this->getWorkspaces();
        foreach ($workspaces as $workspace_index => $workspace){
            $workspace_name = $workspace[1];
            $workspace_namespace = $workspace[2];
            $tasks = $this->getWorkspaceTasks($workspace_namespace);

            $writer->writeLine('    ' . $format->fg_dark_yellow . $workspace_name . $format->reset . ' workspace:');
            foreach($tasks as $task_index => $task){
                $task_listing_type = $task[0];
                $task_name = $task[1];
                $task_description = $task[2];

                $writer->writeLine('        ' . $task_listing_type . ' ' . $format->fg_bright_green . $task_name . $format->reset . ' - ' . $task_description);
            }
        }
    }

    public function displayUnknownParameters()
    {
        $writer = $this->cli_writer;

        $writer->writeLine('Unknown Parameters');
    }

    public function displayVersion()
    {
        $writer = $this->cli_writer;

        $writer->writeLine($this->info->getVersionPlusSemver());
    }

    public function displayWorkspaces()
    {
        $writer = $this->cli_writer;

        $writer->writeLine('Workspaces:');

        $workspaces = $this->getWorkspaces();
        foreach ($workspaces as $workspace_index => $workspace){
            $writer->writeLine('    ' . $workspace_index . ' => ' . $workspace[1]);
        }
    }

    public function getWorkspaces(){
        $workspaces_list_namespace = PITH_APP_TASK_WORKSPACES_LIST;
        $workspaces_list = $this->container->get($workspaces_list_namespace);
        $workspaces = $workspaces_list->workspaces;

        return $workspaces;
    }

    public function getWorkspaceTasks($workspace_list_namespace){
        $workspace_list = $this->container->get($workspace_list_namespace);
        $tasks = $workspace_list->tasks;

        return $tasks;
    }

    public function run()
    {
        global $argv;
        $file = $argv[0] ?? '';
        $positional_parameter_1 = $argv[1] ?? '';
        $positional_parameter_2 = $argv[2] ?? '';
        $positional_parameter_3 = $argv[3] ?? '';

        $has_positional_parameters = $positional_parameter_1 !== '';

        // Short Options
        // ==============================================================
        // $short_options  = "";
        // $short_options .= "f:";  // Required value
        // $short_options .= "v::"; // Optional value
        // $short_options .= "abc"; // These options do not accept values
        // ==============================================================

        // Short Options
        $short_options  = '';
        $short_options .= 'v::';
        $short_options .= 'V::';

        // Long Options
        // ==============================================================
        // $long_options  = array(
        //     "required:",     // Required value
        //     "optional::",    // Optional value
        //     "option",        // No value
        //     "opt",           // No value
        // );
        // ==============================================================

        // Long Options
        $long_options = [
            'version::',
            'Version::',
        ];

        // Get Options
        $options = getopt($short_options, $long_options);
        $option_keys = array_keys($options);
        $has_options = (bool) count($options);

        // List
        // ────
        $has_list_flag = $positional_parameter_1 === 'list';
        if($has_list_flag){
            $this->displayList();
            return;
        }

        // Workspaces
        // ────
        $has_workspaces_flag = $positional_parameter_1 === 'workspaces';
        if($has_workspaces_flag){
            $this->displayWorkspaces();
            return;
        }

        // About
        // ───
        $has_run_flag = $positional_parameter_1 === 'about';
        if($has_run_flag){
            $this->displayAboutTask($positional_parameter_2, $positional_parameter_3);
            return;
        }

        // Run
        // ───
        $has_run_flag = $positional_parameter_1 === 'run';
        if($has_run_flag){
            $this->runTask($positional_parameter_2, $positional_parameter_3);
            return;
        }

        // Version
        // ───────
        $has_version_flag = $this->array_utility->arrayHasValueInsensitive($option_keys,'v') || $this->array_utility->arrayHasValueInsensitive($option_keys,'version') || $positional_parameter_1 === 'version' || $positional_parameter_1 === 'Version';
        if($has_version_flag){
            $this->displayVersion();
            return;
        }

        // Unknown Parameters
        // ──────────────────
        if($has_positional_parameters){
            $this->displayUnknownParameters();
            return;
        }

        // Info
        // ────
        $this->displayInfo();
    }

    public function runTask($given_workspace_name, $given_task_name)
    {
        $app = $this->app_retriever->getApp();
        $writer = $this->cli_writer;
        $format = $this->cli_format;

        //$writer->writeLine('Running.....');

        $workspaces = $this->getWorkspaces();
        foreach ($workspaces as $workspace){
            $workspace_name = $workspace[1];
            $is_workspace_name_a_match = $workspace_name === $given_workspace_name;
            if($is_workspace_name_a_match){
                $workspace_namespace = $workspace[2];
                $tasks = $this->getWorkspaceTasks($workspace_namespace);

                //$writer->writeLine('    ' . $format->fg_dark_yellow . $workspace_name . $format->reset . ' workspace:');
                foreach($tasks as $task){
                    $task_listing_type = $task[0];
                    $task_name = $task[1];
                    $task_description = $task[2];
                    $task_route_namespace = $task[3];
                    //$writer->writeLine('        ' . $task_listing_type . ' ' . $format->fg_bright_green . $task_name . $format->reset . ' - ' . $task_description);

                    $is_task_name_a_match = $task_name === $given_task_name;
                    if($is_task_name_a_match){
                        //$writer->writeLine('Found.....');
                        try{
                            // Set process type
                            $app->process->process_type = 'task';
                            $app->process->boundary_type = 'task-tool';

                            // Set the config to not re-echo the cli writes
                            $app->config->should_echo_cli_output = false;

                            // Run
                            $app->engine->runTaskRoute($task_route_namespace);
                        }
                        catch (PithException $exception){
                            $writer->writeLine($format->fg_bright_red . 'Pith Exception ' . $exception->getCode() . $format->reset);
                            $writer->writeLine($format->fg_bright_red . 'Message: ' . $exception->getMessage() . $format->reset);
                        }
                        catch (Exception $exception){
                            $writer->writeLine($format->fg_bright_red . 'Encountered an exception.' . $format->reset);
                            $writer->writeLine($format->fg_bright_red . 'Exception ' . $exception->getCode() . ' - Message: ' . $exception->getMessage() . $format->reset);
                        }
                        break;
                    }
                }
                break;
            }
        }
        
        if(PITH_COMMAND_TASK_LOG_ENABLE){
            $this->task_logger->logTask($given_workspace_name, $given_task_name);
        }
    }

}