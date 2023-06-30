<?php

/**
 * Account Bar Action
 * ------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithAction;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;

/**
 * Class AccountBarAction
 * @package Pith\Framework\SharedInfrastructure
 */
class AccountBarAction extends PithAction
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
        $is_logged_in    = $app->active_user->isLoggedIn();
        $anti_csrf_token = $_SESSION['anti_csrf_token'] ?? '';
        $display_name    = $_SESSION['username'] ?? '';

        // Push to Preparer
        $this->prepare->is_logged_in    = $is_logged_in;
        $this->prepare->anti_csrf_token = $anti_csrf_token;
        $this->prepare->display_name    = $display_name;
    }
}