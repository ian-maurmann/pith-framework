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
 * 'do-login-user' Access Level
 * ---------------------
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

/**
 * Class DoLoginUserAccessLevel
 * @package Pith\Framework\Internal
 */
class DoLoginUserAccessLevel extends PithAccessLevel
{
    private PithAppRetriever $app_retriever;

    public function __construct(PithAppRetriever $app_retriever){
        // Set object dependencies
        $this->app_retriever = $app_retriever;
    }

    public function isAllowedToAccess(): bool
    {
        // "dev-ip" access;

        // Default to deny access
        $is_allowed = false;

        // Get the app
        $app = $this->app_retriever->getApp();

        $username_unsafe = $_POST['username'];
        $password_unsafe = $_POST['password'];

        $is_valid = $app->active_user->attemptToLogInWithUsernameAndPassword($username_unsafe, $password_unsafe);

        echo $is_valid ? ' LOGIN ' : ' NO LOGIN ';

        $is_allowed = true;


        return $is_allowed;
    }
}