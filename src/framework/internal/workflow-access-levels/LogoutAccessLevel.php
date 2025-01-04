<?php
# ===================================================================
# Copyright (c) 2008-2025 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


/**
 * 'logout' Access Level
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

use Pith\Workflow\PithAccessLevel;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;

/**
 * Class LogoutAccessLevel
 * @package Pith\Framework\Internal
 */
class LogoutAccessLevel extends PithAccessLevel
{
    private PithAppRetriever $app_retriever;

    public function __construct(PithAppRetriever $app_retriever){
        // Set object dependencies
        $this->app_retriever = $app_retriever;
    }


    /**
     * @return bool
     */
    public function isAllowedToAccess(): bool
    {
        // "logout" access

        try {
            $note = '';

            // Get the app
            $app = $this->app_retriever->getApp();

            // Get the REQUEST vars
            $token_unsafe = $_REQUEST['token'] ?? '';

            $is_logged_in = $app->active_user->isLoggedIn();

            // Check the token
            $token_length = mb_strlen($token_unsafe);
            $has_token    = $token_length > 0;

            if($has_token){
                // Try to log out
                $did_log_out = $app->active_user->logOutWithToken($token_unsafe);

                if($did_log_out){
                    $note = 'logout-successful';
                }
                else{
                    $note = $is_logged_in ? 'logout-failed' : 'logout-failed-not-logged-in';
                }
            }
            else{
                $note = $is_logged_in ? 'logout-failed-no-token' : 'logout-failed-not-logged-in';
            }

            // Add note
            //$app->registry->access_level_note = $note;
            $app->registry->setRuntimeNoteOnce('logout-note', $note);


        } catch (PithException $e) {
            return false;
        }

        // Should redirect before this point, else return false
        return true;
    }
}