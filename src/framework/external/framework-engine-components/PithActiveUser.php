<?php /** @noinspection PhpPropertyNamingConventionInspection */
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
 */


declare(strict_types=1);

namespace Pith\Framework;



use Pith\Framework\Internal\PithImpressionLoggingTool;

/**
 * Class PithActiveUser
 * @package Pith\Framework
 */
class PithActiveUser
{
    private PithImpressionLoggingTool $impression_tool;
    private PithAppRetriever          $app_retriever;

    private bool   $did_log_impression_on_first_access;

    private string $remote_ip_address = '';

    private string $client_ua_string = '';
    private string $client_hint_ua_string = '';
    private string $client_hint_ua_mobile_string = '';
    private string $client_hint_ua_platform_string = '';
    private string $client_accept_language_string = '';
    private string $requested_server_port = '';
    private string $requested_uri = '';
    private string $requested_http_method = '';
    private string $client_referer_string = '';

    public function __construct(PithImpressionLoggingTool $impression_tool, PithAppRetriever $app_retriever)
    {
        // Set object dependencies
        $this->impression_tool = $impression_tool;
        $this->app_retriever   = $app_retriever;

        // Set defaults
        $this->did_log_impression_on_first_access = false;
    }

    public function start(){
        $this->remote_ip_address              = $_SERVER['REMOTE_ADDR']             ?? '';
        $this->client_ua_string               = $_SERVER['HTTP_USER_AGENT']         ?? '';
        $this->client_hint_ua_string          = $_SERVER['HTTP_SEC_CH_UA']          ?? '';
        $this->client_hint_ua_mobile_string   = $_SERVER['HTTP_SEC_CH_UA_MOBILE']   ?? '';
        $this->client_hint_ua_platform_string = $_SERVER['HTTP_SEC_CH_UA_PLATFORM'] ?? '';
        $this->client_accept_language_string  = $_SERVER['HTTP_ACCEPT_LANGUAGE']    ?? '';
        $this->requested_server_port          = $_SERVER['SERVER_PORT']             ?? '';
        $this->requested_uri                  = $_SERVER['REQUEST_URI']             ?? '';
        $this->requested_http_method          = $_SERVER['REQUEST_METHOD']          ?? '';
        $this->client_referer_string          = $_SERVER['HTTP_REFERER']            ?? '';
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
     * @param bool $access_success
     */
    public function logImpressionOnFirstAccessOnly(string $access_level, bool $access_success)
    {
        if(!$this->did_log_impression_on_first_access){

            // Request
            $this->impression_tool->setRequestedHttpMethod($this->requested_http_method);
            $this->impression_tool->setRequestedUri($this->requested_uri);
            $this->impression_tool->setRequestedServerPort($this->requested_server_port);

            // Access
            $this->impression_tool->setAccessLevel($access_level);
            $this->impression_tool->setAccessSuccess($access_success);

            // Client
            $this->impression_tool->setRemoteIpAddress($this->remote_ip_address);
            $this->impression_tool->setClientUaString($this->client_ua_string);
            $this->impression_tool->setClientHintUaString($this->client_hint_ua_string);
            $this->impression_tool->setClientHintUaMobileString($this->client_hint_ua_mobile_string);
            $this->impression_tool->setClientHintUaPlatformString($this->client_hint_ua_platform_string);
            $this->impression_tool->setClientAcceptLanguageString($this->client_accept_language_string);

            // Referer
            $this->impression_tool->setClientRefererString($this->client_referer_string);

            // Run
            $this->impression_tool->logImpression();

            // Mark that this ran
            $this->did_log_impression_on_first_access = true;
        }
    }

}