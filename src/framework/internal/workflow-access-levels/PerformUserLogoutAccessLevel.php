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
 * 'perform-user-logout' Access Level
 * ---------------------------------
 *
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
 * @noinspection PhpMissingParentCallCommonInspection  - Access level parent methods exist as fallback.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */
declare(strict_types=1);


namespace Pith\Framework\Internal;

use Pith\Framework\PithAccessLevel;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;

/**
 * Class PerformUserLogoutAccessLevel
 * @package Pith\Framework\Internal
 */
class PerformUserLogoutAccessLevel extends PithAccessLevel
{
    private PithAppRetriever $app_retriever;

    public function __construct(PithAppRetriever $app_retriever){
        // Set object dependencies
        $this->app_retriever = $app_retriever;
    }

    /** @noinspection PhpUnusedLocalVariableInspection */
    public function isAllowedToAccess(): bool
    {
        // "perform-user-logout" access;
        try {
            // Get the app
            $app = $this->app_retriever->getApp();

            // Get the REQUEST vars
            $token_unsafe = $_REQUEST['token'] ?? '';

            // Attempt to logout, should redirect
            $app->active_user->attemptToLogOutWithTokenAndRedirect($token_unsafe);
        } catch (PithException $e) {
            return false;
        }

        // Should redirect before this point, else return false
        return false;
    }
}