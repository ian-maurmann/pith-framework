<?php

/**
 * Logout Action
 * -------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithAction;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;

/**
 * Class LogoutAction
 * @package Pith\Framework\SharedInfrastructure
 */
class LogoutAction extends PithAction
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

        // Variables
        // $logout_note = $app->registry->access_level_note;
        $logout_note = $app->registry->getRuntimeNote('logout-note');

        // Push to Preparer
        $this->prepare->logout_note = $logout_note;
    }
}