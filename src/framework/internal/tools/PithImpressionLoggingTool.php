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
 * Pith Impression Logging Tool
 * ----------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names is ok.
 * @noinspection PhpPropertyNamingConventionInspection - Long property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Internal;


/**
 * Class PithImpressionLoggingTool
 * @package Pith\Framework\Internal
 */
class PithImpressionLoggingTool
{
    private PithImpressionLogger $impression_logger;

    private string $remote_ip_address = '';
    private string $access_level = '';
    private bool $access_success;
    private string $requested_uri;

    private string $client_ua_string = '';
    private string $client_hint_ua_string = '';
    private string $client_hint_ua_mobile_string = '';
    private string $client_hint_ua_platform_string = '';
    private string $client_accept_language_string = '';
    private string $requested_server_port = '';
    private string $requested_http_method = '';
    private string $client_referer_string = '';

    public function __construct(PithImpressionLogger $impression_logger)
    {
        // Set object dependencies
        $this->impression_logger = $impression_logger;
    }

    /**
     * @param string $remote_ip_address
     */
    public function setRemoteIpAddress(string $remote_ip_address): void
    {
        $this->remote_ip_address = $remote_ip_address;
    }

    /**
     * @param string $access_level
     */
    public function setAccessLevel(string $access_level): void
    {
        $this->access_level = $access_level;
    }

    /**
     * @param bool $access_success
     */
    public function setAccessSuccess(bool $access_success): void
    {
        $this->access_success = $access_success;
    }


    /**
     * @param string $requested_uri
     */
    public function setRequestedUri(string $requested_uri): void
    {
        $this->requested_uri = $requested_uri;
    }

    /**
     * @param string $requested_http_method
     */
    public function setRequestedHttpMethod(string $requested_http_method): void
    {
        $this->requested_http_method = $requested_http_method;
    }

    /**
     * @param string $requested_server_port
     */
    public function setRequestedServerPort(string $requested_server_port): void
    {
        $this->requested_server_port = $requested_server_port;
    }

    /**
     * @param string $client_referer_string
     */
    public function setClientRefererString(string $client_referer_string): void
    {
        $this->client_referer_string = $client_referer_string;
    }

    /**
     * @param string $client_ua_string
     */
    public function setClientUaString(string $client_ua_string): void
    {
        $this->client_ua_string = $client_ua_string;
    }

    /**
     * @param string $client_hint_ua_string
     */
    public function setClientHintUaString(string $client_hint_ua_string): void
    {
        $this->client_hint_ua_string = $client_hint_ua_string;
    }

    /**
     * @param string $client_hint_ua_mobile_string
     */
    public function setClientHintUaMobileString(string $client_hint_ua_mobile_string): void
    {
        $this->client_hint_ua_mobile_string = $client_hint_ua_mobile_string;
    }

    /**
     * @param string $client_hint_ua_platform_string
     */
    public function setClientHintUaPlatformString(string $client_hint_ua_platform_string): void
    {
        $this->client_hint_ua_platform_string = $client_hint_ua_platform_string;
    }


    /**
     * @param string $client_accept_language_string
     */
    public function setClientAcceptLanguageString(string $client_accept_language_string): void
    {
        $this->client_accept_language_string = $client_accept_language_string;
    }



    public function logImpression()
    {
        $this->impression_logger->logImpression(
            $this->requested_http_method,
            $this->requested_uri,
            $this->requested_server_port,

            $this->access_level,
            $this->access_success,

            $this->remote_ip_address,
            $this->client_ua_string,
            $this->client_hint_ua_string,
            $this->client_hint_ua_mobile_string,
            $this->client_hint_ua_platform_string,
            $this->client_accept_language_string,

            $this->client_referer_string,
        );
    }
}