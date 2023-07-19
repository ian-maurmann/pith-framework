<?php

/**
 * Main Layout Action
 * ------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel\Theme;

use Pith\Framework\PithAction;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;

/**
 * Class MainLayoutAction
 * @package Pith\Framework\Panel\Theme
 */
class MainLayoutAction extends PithAction
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
        $color_scheme = $app->active_user->getUserColorScheme() ?: 'auto';

        // Push to Preparer
        $this->prepare->PITH_PANEL_PATH = PITH_PANEL_PATH;
        $this->prepare->color_scheme    = $color_scheme;
    }
}