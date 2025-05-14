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
 * Pith Active User
 * ----------------
 *
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Long property names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection - Ignore for readability.
 */


declare(strict_types=1);

namespace Pith\Framework;

use Pith\Framework\Internal\PithImpressionLogger;
//use Pith\Framework\SharedInfrastructure\Model\UserSystem\UserService;
//use Pith\Framework\Plugin\UserSystem3\UserService;
use Pith\Framework\Plugin\UserSystem4\UserService;

/**
 * Class PithActiveUser
 * @package Pith\Framework
 */
class PithActiveUser
{
    // Dependencies
    private PithAppRetriever     $app_retriever;
    private PithImpressionLogger $impression_logger;
    private UserService          $user_service;

    // $_SERVER info, User Agent info, CH info
    private string $ch_down_link;
    private string $ch_prefers_color_scheme;
    private string $ch_viewport_width;
    private string $ch_ua;
    private string $ch_ua_architecture;
    private string $ch_ua_bits;
    private string $ch_ua_mobile;
    private string $ch_ua_model;
    private string $ch_ua_platform;
    private string $ch_ua_platform_version;
    private string $client_accept_language_string;
    private string $client_referer_string;
    private string $remote_ip_address;
    private string $requested_http_method;
    private string $requested_server_port;
    private string $requested_uri;
    private string $session_id = '';
    private string $user_agent_string;
    private int    $user_id = 0;

    // Properties
    private bool $did_log_impression_on_first_access;


    public function __construct(PithAppRetriever $app_retriever, PithImpressionLogger $impression_logger, UserService $user_service)
    {
        // Set object dependencies
        $this->app_retriever     = $app_retriever;
        $this->impression_logger = $impression_logger;
        $this->user_service      = $user_service;

        // Set first-run flags
        $this->did_log_impression_on_first_access = false;

        // Set user info defaults
        // $this->session_id = '';
        // $this->user_id    = 0;
    }

    /**
     * @noinspection SpellCheckingInspection - Ignore "addr", "bitness", and "downlink" not being real words
     */
    public function init(){

        // Save what the user requested
        $this->requested_http_method = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->requested_uri         = $_SERVER['REQUEST_URI']    ?? '';
        $this->requested_server_port = $_SERVER['SERVER_PORT']    ?? '';

        // Save info about what the user identified itself as being
        $this->remote_ip_address = $_SERVER['REMOTE_ADDR'] ?? '';

        // User Agent
        $this->user_agent_string = $_SERVER['HTTP_USER_AGENT'] ?? '';

        // CH UA Hinting Info (Might or might not be set, or true)
        $this->ch_ua                  = $_SERVER['HTTP_SEC_CH_UA']                  ?? '';
        $this->ch_ua_platform         = $_SERVER['HTTP_SEC_CH_UA_PLATFORM']         ?? '';
        $this->ch_ua_platform_version = $_SERVER['HTTP_SEC_CH_UA_PLATFORM_VERSION'] ?? '';
        $this->ch_ua_mobile           = $_SERVER['HTTP_SEC_CH_UA_MOBILE']           ?? '';
        $this->ch_ua_model            = $_SERVER['HTTP_SEC_CH_UA_MODEL']            ?? '';
        $this->ch_ua_architecture     = $_SERVER['HTTP_SEC_CH_UA_ARCH']             ?? '';
        $this->ch_ua_bits             = $_SERVER['HTTP_SEC_CH_UA_BITNESS']          ?? '';

        // User's web-browser's set language
        $this->client_accept_language_string = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';

        // Referer
        $this->client_referer_string = $_SERVER['HTTP_REFERER'] ?? '';

        // Other CH Hinting Info
        $this->ch_down_link            = $_SERVER['HTTP_DOWNLINK']                    ?? '';
        $this->ch_viewport_width       = $_SERVER['HTTP_VIEWPORT_WIDTH']              ?? '';
        $this->ch_prefers_color_scheme = $_SERVER['HTTP_SEC_CH_PREFERS_COLOR_SCHEME'] ?? '';

        // Get app
        // $app = $this->app_retriever->getApp();

        // Load-up the session
        // $app->session_manager->loadSession();
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function start(){
        // Get app
        $app = $this->app_retriever->getApp();

        // Load-up the session
        $app->session_manager->loadSession();

        // Store user info for later
        $this->session_id = $app->session_manager->getSessionId();
        $this->user_id    = $app->session_manager->getUserId();
    }

    /**
     * @return string
     */
    public function getRemoteIpAddress(): string
    {
        return $this->remote_ip_address;
    }

    /**
     * @param string $access_level
     * @param bool   $access_success
     * @throws PithException
     */
    public function logImpressionOnFirstAccessOnly(string $access_level, bool $access_success)
    {
        if(PITH_IMPRESSION_LOG_ENABLE) {
            if (!$this->did_log_impression_on_first_access) {

                // Run
                $this->impression_logger->logImpression(
                    $this->requested_http_method,
                    $this->requested_uri,
                    (string) $this->requested_server_port,

                    $access_level,
                    $access_success,

                    (string) $this->remote_ip_address,
                    (string) $this->session_id,
                    $this->isUser() ? 'user' : 'guest',
                    (string) $this->user_id,

                    $this->user_agent_string,
                    $this->ch_ua,
                    $this->ch_ua_platform,
                    $this->ch_ua_platform_version,
                    $this->ch_ua_mobile,
                    $this->ch_ua_model,
                    $this->ch_ua_architecture,
                    $this->ch_ua_bits,

                    $this->client_accept_language_string,

                    $this->client_referer_string,

                    $this->ch_down_link,
                    $this->ch_viewport_width,
                    $this->ch_prefers_color_scheme
                );

                // Mark that this ran
                $this->did_log_impression_on_first_access = true;
            }
        }
    }

    /**
     * @param string $given_username
     * @param string $given_password
     * @throws PithException
     *
     * @noinspection PhpIfWithCommonPartsInspection - Ignore common parts warning.
     * @noinspection PhpNoReturnAttributeCanBeAddedInspection - Ignore no-return.
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpUnusedLocalVariableInspection
     */
    public function attemptToLogInWithUsernameAndPassword(string $given_username, string $given_password): void
    {
        // Get login info
        $login_validation_info = $this->user_service->getLoginValidationWithUsernameAndPassword($given_username, $given_password);
        $is_login_valid        = $login_validation_info['is_login_valid_yn'] === 'yes';
        $login_failure_reason  = (string) $login_validation_info['fail_reason'];
        $user_id               = (int) $login_validation_info['user_id'];
        $username              = (string) $login_validation_info['username'];
        $username_lower        = (string) $login_validation_info['username_lower'];
        $login_time            = (int) $login_validation_info['login_time'];

        if($is_login_valid){
            // Get app
            $app = $this->app_retriever->getApp();

            // Build new user session
            $app->session_manager->buildUserSession($user_id, $username, $username_lower, $login_time);

            // Redirect to user successful login landing
            header('Location: ' . SHARED_UI_USER_LOGIN_SUCCESS_LANDING_PAGE_LINK, true, 302);
            exit;
        }
        else{
            // Redirect to user failed login form
            header('Location: ' . PITH_APP_DEFAULT_LOGIN_PAGE_URL_PATH . '?login-failed', true, 302);
            exit;
        }
    }


    /**
     * @param string $given_anti_csrf_token
     * @return bool
     * @throws PithException
     */
    public function logOutWithToken(string $given_anti_csrf_token): bool
    {
        $did_log_out = false;

        // Get the app
        $app = $this->app_retriever->getApp();

        // Load up the session
        $app->session_manager->loadSession();

        // Get the session's anti-CSRF token
        $session_anti_csrf_token = $_SESSION['anti_csrf_token'] ?? '';

        // Check if the anti-CSRF tokens match, or are both empty
        $is_a_match = $given_anti_csrf_token === $session_anti_csrf_token;

        // If is a match, kill session
        if($is_a_match){
            $app->session_manager->killSession();
            $did_log_out = true;
        }

        return $did_log_out;
    }

    /**
     * @param string $given_anti_csrf_token
     * @throws PithException
     *
     * @noinspection PhpIfWithCommonPartsInspection
     * @noinspection PhpNoReturnAttributeCanBeAddedInspection
     */
    public function attemptToLogOutWithTokenAndRedirect(string $given_anti_csrf_token)
    {
        // Try to log out
        $did_log_out = $this->logOutWithToken($given_anti_csrf_token);
        
        if($did_log_out){
            // Redirect to user successful logout landing
            header('Location: ' . SHARED_UI_USER_LOGOUT_SUCCESS_LANDING_PAGE_LINK, true, 302);
            exit;
        }
        else{
            // Redirect to user successful logout landing
            header('Location: ' . SHARED_UI_USER_LOGOUT_FAILURE_LANDING_PAGE_LINK, true, 302);
            exit;
        }
    }


    /**
     * @return bool
     * @throws PithException
     */
    public function isLoggedIn(): bool
    {
        // Get app
        $app = $this->app_retriever->getApp();

        // Get is logged in
        $is_logged_in = $app->session_manager->isLoggedIn();

        // Return true if logged in, else return false
        return $is_logged_in;
    }

    /**
     * @return bool
     * @throws PithException
     */
    public function isUser(): bool
    {
        // Get app
        $app = $this->app_retriever->getApp();

        // Get is logged in user or higher
        $is_logged_in_user = $app->session_manager->isLoggedInUser();

        // Return true if is a logged in user or above, else return false
        return $is_logged_in_user;
    }

    /**
     * @return bool
     * @throws PithException
     */
    public function isWebmaster(): bool
    {
        $is_webmaster = false;

        // Get app
        $app = $this->app_retriever->getApp();

        // Get is logged in user or higher
        $is_logged_in_user = $app->session_manager->isLoggedInUser();

        if($is_logged_in_user){
            $is_webmaster = $app->session_manager->isWebmaster();
        }

        // Return true if is a logged in user or above, else return false
        return $is_webmaster;
    }

    /**
     * @return string
     */
    public function getUserColorScheme(): string
    {
        // Return the color mode, ex: 'light', 'dark', ''
        return $this->ch_prefers_color_scheme;
    }

    /**
     * @return bool
     * @throws PithException
     */
    public function isInternal(): bool
    {
        // Default to false
        $is_internal  = false;

        // Get app
        $app = $this->app_retriever->getApp();

        // Get is logged in user or higher
        $is_logged_in_user = $app->session_manager->isLoggedInUser();

        if($is_logged_in_user){
            // Check for internal user types
            $is_webmaster = $app->session_manager->isWebmaster();
            // ^... Add types as needed

            // Check if is an internal user
            $is_internal = $is_webmaster; // ... Add types as needed
        }

        // Return true if is a logged in user or above, else return false
        return $is_internal;
    }

}