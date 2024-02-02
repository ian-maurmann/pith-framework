<?php

/**
 * Tick Task Workspace
 * -------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection   - Using PSR-4, not PSR-0.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Tasks;


/**
 * Class TickTaskWorkspace
 * @package Pith\Framework\SharedInfrastructure\Tasks
 */
class TickTaskWorkspace
{
    public array $tasks = [
        ['task', 'tick', 'Run other systems.', '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\Tick\\TickTaskRoute'],
    ];
}