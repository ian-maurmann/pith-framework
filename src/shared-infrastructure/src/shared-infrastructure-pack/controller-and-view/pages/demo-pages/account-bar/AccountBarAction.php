<?php

/**
 * Account Bar Action
 * -------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use IKM\CopyrightYearUtility\CopyrightYearUtility;
use Pith\Framework\PithAction;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;
use Pith\Framework\PithInfo;

/**
 * Class AccountBarAction
 * @package Pith\Framework\SharedInfrastructure
 */
class AccountBarAction extends PithAction
{
    private CopyrightYearUtility $copyright_year_utility;
    private PithInfo $pith_info;
    private PithAppRetriever $app_retriever;

    public function __construct(CopyrightYearUtility $copyright_year_utility, PithInfo $pith_info, PithAppRetriever $app_retriever)
    {
        // Add Objects
        $this->copyright_year_utility = $copyright_year_utility;
        $this->pith_info = $pith_info;
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
        $anti_csrf_token = $_SESSION['anti_csrf_token'] ?? '________';

        // Push to Preparer
        $this->prepare->is_logged_in    = $is_logged_in;
        $this->prepare->anti_csrf_token = $anti_csrf_token;
    }
}