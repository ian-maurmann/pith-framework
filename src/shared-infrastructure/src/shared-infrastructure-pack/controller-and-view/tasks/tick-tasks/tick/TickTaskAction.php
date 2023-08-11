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
 */

declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Tasks\Tick;

use Pith\Framework\PithAction;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;

/**
 * Class TickTaskAction
 * @package Pith\Framework\SharedInfrastructure\Tasks\Tick
 */
class TickTaskAction extends PithAction
{
    private PithAppRetriever $app_retriever;

    public function __construct(PithAppRetriever $app_retriever)
    {
        // Set object dependencies
        $this->app_retriever = $app_retriever;
    }

    /**
     * @throws PithException
     */
    public function runAction()
    {
        // Get app
        $app = $this->app_retriever->getApp();

        // Test the CLI Writer ---- CLI View Adapter show also remember this in the view
        $app->cli_writer->writeLine('Hello, World!');
        $app->cli_writer->writeLine('Jello!');
        $app->cli_writer->writeLine('Jello!');
        $app->cli_writer->writeLine('More jello!');
    }

}