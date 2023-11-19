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
use Pith\Framework\Internal\PithArrayUtility;
use Pith\Framework\PithCliFormat;
use Pith\Framework\PithCliWriter;
use Pith\Framework\PithInfo;


class PithTaskTool
{
    private PithArrayUtility $array_utility;
    private PithCliFormat    $cli_format;
    private PithCliWriter    $cli_writer;
    private Container        $container;
    private PithInfo         $info;

    public function __construct()
    {
        // Add objects
        $this->container     = new Container();
        $this->array_utility = $this->container->get('Pith\\Framework\\Internal\\PithArrayUtility');
        $this->cli_format    = $this->container->get('Pith\\Framework\\PithCliFormat');
        $this->cli_writer    = $this->container->get('Pith\\Framework\\PithCliWriter');
        $this->info          = $this->container->get('Pith\\Framework\\PithInfo');
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
}