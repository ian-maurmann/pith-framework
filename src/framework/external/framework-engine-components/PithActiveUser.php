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
use Pith\Framework\SharedInfrastructure\Model\UserSystem\UserService;

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
    private string $user_agent_string;

    // Properties
    private bool $did_log_impression_on_first_access;


    public function __construct(PithAppRetriever $app_retriever, PithImpressionLogger $impression_logger, UserService $user_service)
    {
        // Set object dependencies
        $this->app_retriever     = $app_retriever;
        $this->impression_logger = $impression_logger;
        $this->user_service      = $user_service;

        // Set defaults
        $this->did_log_impression_on_first_access = false;
    }

    /**
     * @noinspection SpellCheckingInspection - Ignore "addr", "bitness", and "downlink" not being real words
     */
    public function start(){

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
                    $this->requested_server_port,

                    $access_level,
                    $access_success,

                    $this->remote_ip_address,
                    '(TODO: Session ID)', // TODO: Session ID will do here
                    '(guest)',
                    '(TODO: User ID)', // TODO: User ID will do here

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

    public function attemptToLogInWithUsernameAndPassword($given_username, $given_password)
    {
        $is_login_valid = $this->user_service->isLoginValidWithUsernameAndPassword($given_username, $given_password);

        return $is_login_valid;
    }

}