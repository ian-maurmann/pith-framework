<?php

/**
 * Task Workspaces List
 * ----------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection   - Using PSR-4, not PSR-0.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Tasks;


/**
 * Class TaskWorkspacesList
 * @package Pith\Framework\SharedInfrastructure\Tasks
 */
class TaskWorkspacesList
{
    public array $workspaces = [
        // Tick workspace
        ['workspace', 'tick', '\\Pith\\Tick\\TickTaskWorkspace', null],

        // Janitor workspace
        ['workspace', 'janitor', '\\Pith\\Janitor\\JanitorTaskWorkspace', '\\Pith\\Janitor\\JanitorTaskOrchestrator'],

        // Other workspaces
        //['workspace', 'impression_system', '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTaskWorkspace', '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\ImpressionLoggingTaskOrchestrator'],
    ];
}