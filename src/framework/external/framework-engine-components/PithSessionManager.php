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
 * Pith Session Manager
 * --------------------
 *
 * @noinspection PhpUnnecessaryLocalVariableInspection - Ignore for readability.
 */

declare(strict_types=1);


namespace Pith\Framework;


use Exception;
use Pith\Framework\SharedInfrastructure\Model\Random\RandomTokenUtility;

/**
 * Class PithSessionManager
 * @package Pith\Framework
 */
class PithSessionManager
{
    private RandomTokenUtility $random_token_utility;

    private bool $did_load_session_already;

    public function __construct(RandomTokenUtility $random_token_utility)
    {
        // Set object dependencies
        $this->random_token_utility = $random_token_utility;

        // Set defaults
        $this->did_load_session_already = false;
    }

    public function loadSession()
    {
        if(!$this->did_load_session_already){
            @session_start();

            $this->did_load_session_already = true;
        }
    }

    public function createNewSession()
    {
        // Kill the old session
        $this->killSession();

        // (re)-initialize the session.
        @session_start();

        // Re-generate the session id
        session_regenerate_id(true);
    }

    public function killSession()
    {
        // (Re)-initialize the session
        @session_start();

        // Unset all of the session variables
        $_SESSION = [];

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session
        session_destroy();
    }

    /**
     * @throws Exception
     */
    public function buildUserSession(int $user_id, string $username, string $username_lower, int $login_time)
    {
        // Make fresh new session / kill old session
        $this->createNewSession();

        // Reset all of the session variables
        $_SESSION = [];

        // Build session variables
        $_SESSION['has_session_yn']       = 'yes';
        $_SESSION['is_logged_in_yn']      = 'yes';
        $_SESSION['session_type']         = 'user';
        $_SESSION['session_created_time'] = time();
        $_SESSION['user_id']              = $user_id;
        $_SESSION['username']             = $username;
        $_SESSION['username_lower']       = $username_lower;
        $_SESSION['login_time']           = $login_time;
        $_SESSION['anti_csrf_token']      = $this->random_token_utility->getRandomAntiCsrfToken();
    }

    public function hasSession(): bool
    {
        $this->loadSession();

        $has_session_yn = $_SESSION['has_session_yn'] ?? 'no';
        $has_session    = $has_session_yn === 'yes';

        return $has_session;
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        $is_logged_in = false;
        $has_session  = $this->hasSession();

        if($has_session){
            $is_logged_in_yn = $_SESSION['is_logged_in_yn'] ?? 'no';
            $is_logged_in    = $is_logged_in_yn === 'yes';
        }

        return $is_logged_in;
    }

}