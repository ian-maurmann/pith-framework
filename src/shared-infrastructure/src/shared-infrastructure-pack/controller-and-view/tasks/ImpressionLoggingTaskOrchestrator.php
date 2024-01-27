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
 * Pith Task Orchestrator (extend)
 * -------------------------------
 *
 * @noinspection PhpIllegalPsrClassPathInspection - Using PSR-4, not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Tasks;

use Pith\Framework\Internal\PithTimeWindowUtility;
use Pith\Framework\Internal\PithTouchstoneUtility;
use Pith\Framework\PithTaskOrchestrator;

/**
 * Class PithTaskOrchestrator
 * @package Pith\Framework\SharedInfrastructure\Tasks
 */
class ImpressionLoggingTaskOrchestrator extends PithTaskOrchestrator
{
    protected PithTouchstoneUtility $touchstone_utility;

    public function __construct()
    {
        // Set object dependencies
        $this->touchstone_utility = new PithTouchstoneUtility();
    }

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection - Ignore for now. */
    public function orchestrate(bool $skip_heavy = false): array
    {
        // Default
        $orchestration_info = [
            'touchstones'        => [],
            'did_run_task'       => false,
            'ran_task_name'      => '',
            'is_heavy'           => false,
            'skipped_task_names' => [],
        ];


        $ran = $this->processTask($skip_heavy,$orchestration_info, 'impression_system','gather_unique_daily_views', true );
        if($ran){
            return $orchestration_info;
        }

        $ran = $this->processTask($skip_heavy,$orchestration_info, 'impression_system','cleanup_impression_log_loading_queue', false );
        if($ran){
            return $orchestration_info;
        }

        $ran = $this->processTask($skip_heavy,$orchestration_info, 'impression_system','delete_loaded_impression_log', false );
        if($ran){
            return $orchestration_info;
        }

        $ran = $this->processTask($skip_heavy,$orchestration_info, 'impression_system','import_impression_log_to_database', true );
        if($ran){
            return $orchestration_info;
        }

        $ran = $this->processTask($skip_heavy,$orchestration_info, 'impression_system','queue_impression_logs_for_import', true );
        if($ran){
            return $orchestration_info;
        }

        return $orchestration_info;
    }

    protected function processTask(bool $skip_heavy, array &$orchestration_info, string $task_system_name, string $task_name, bool $is_heavy)
    {
        $touchstone_utility = $this->touchstone_utility;

        if($is_heavy && $skip_heavy){
            $orchestration_info['skipped_task_names'][] = $task_name;
        }
        else{
            // Set touchstone file
            $touchstone_file = PITH_TOUCHSTONE_FOLDER_LOCATION . $task_system_name . '/' . $task_name . '.touchstone.txt';
            $orchestration_info['touchstones'][] = $touchstone_file;

            $run = $touchstone_utility->touchOnceIn20MinuteWindow($touchstone_file);

            if($run){
                // Build the command
                $command_string = sprintf(PITH_TASK_SHELL_COMMAND_FORMAT, $task_system_name, $task_name);

                // Run
                shell_exec($command_string);

                $orchestration_info['did_run_task'] = true;
                $orchestration_info['ran_task_name'] = $task_name;
                $orchestration_info['is_heavy'] = $is_heavy;
                
                //return $orchestration_info;
                return true;
            }
        }

        return false;
    }
}