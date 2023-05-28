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
 * Pith Impression Logger
 * ----------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names is ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Internal;


use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;

/**
 * Class PithImpressionLogger
 * @package Pith\Framework\Internal
 */
class PithImpressionLogger
{
    private PithAppRetriever $app_retriever;

    public function __construct(PithAppRetriever $app_retriever)
    {
        // Set object dependencies
        $this->app_retriever = $app_retriever;
    }


    /**
     * @param string $requested_http_method
     * @param string $requested_uri
     * @param string $requested_server_port
     * @param string $access_level
     * @param bool   $access_success
     * @param string $remote_ip_address
     * @param string $session_id_string
     * @param string $user_or_guest
     * @param string $user_id_string
     * @param string $user_agent_string
     * @param string $ch_ua
     * @param string $ch_ua_platform
     * @param string $ch_ua_platform_version
     * @param string $ch_ua_mobile
     * @param string $ch_ua_model
     * @param string $ch_ua_architecture
     * @param string $ch_ua_bitness
     * @param string $client_accept_language_string
     * @param string $client_referer_string
     * @param string $ch_downlink
     * @param string $ch_viewport_width
     * @param string $ch_prefers_color_scheme
     * @throws PithException
     * @noinspection PhpTooManyParametersInspection - Ignore.
     * @noinspection SpellCheckingInspection - Ignore "bitness" and "downlink" not being real words
     * @noinspection PhpUnusedLocalVariableInspection - Ignore $bytes_written not being used for now.
     * @noinspection DuplicatedCode - Ignore the DuplicatedCode warning.
     */
    public function logImpression(
        string $requested_http_method,
        string $requested_uri,
        string $requested_server_port,

        string $access_level,
        bool   $access_success,

        string $remote_ip_address,
        string $session_id_string,
        string $user_or_guest,
        string $user_id_string,

        string $user_agent_string,
        string $ch_ua,
        string $ch_ua_platform,
        string $ch_ua_platform_version,
        string $ch_ua_mobile,
        string $ch_ua_model,
        string $ch_ua_architecture,
        string $ch_ua_bitness,

        string $client_accept_language_string,

        string $client_referer_string,

        string $ch_downlink,
        string $ch_viewport_width,
        string $ch_prefers_color_scheme
    )
    {
        // Get the app
        $app = $this->app_retriever->getApp();

        // Time
        $time               = $app->clock->getLaunchMomentTimestamp();
        $hour_time          = $app->clock->getLaunchMomentHourTimestamp();
        $message_date       = date('Y-m-d H:i:s', $time);
        $filename_date_day  = date('Y-m-d', $hour_time);
        $filename_date_time = date('H-i', $hour_time);

        // Filename
        $filename = 'logs/impressions-log/impressions_'.$filename_date_day.'_at_'.$filename_date_time.'.log';

        // Access Control's response
        $allowed_or_denied = ($access_success) ? 'allowed' : 'denied';

        // Prepare the message variables
        $formatted_requested_http_method         = $this->escapeImpressionLogDelimiters($requested_http_method);
        $formatted_requested_uri                 = $this->escapeImpressionLogDelimiters($requested_uri);
        $formatted_requested_server_port         = $this->escapeImpressionLogDelimiters($requested_server_port);
        $formatted_session_id_string             = $this->escapeImpressionLogDelimiters($session_id_string);
        $formatted_user_agent_string             = $this->escapeImpressionLogDelimiters($user_agent_string);
        $formatted_ch_ua                         = $this->escapeImpressionLogDelimiters($ch_ua);
        $formatted_ch_ua_platform                = $this->escapeImpressionLogDelimiters($ch_ua_platform);
        $formatted_ch_ua_platform_version        = $this->escapeImpressionLogDelimiters($ch_ua_platform_version);
        $formatted_ch_ua_mobile                  = $this->escapeImpressionLogDelimiters($ch_ua_mobile);
        $formatted_ch_ua_model                   = $this->escapeImpressionLogDelimiters($ch_ua_model);
        $formatted_ch_ua_architecture            = $this->escapeImpressionLogDelimiters($ch_ua_architecture);
        $formatted_ch_ua_bitness                 = $this->escapeImpressionLogDelimiters($ch_ua_bitness);
        $formatted_client_accept_language_string = $this->escapeImpressionLogDelimiters($client_accept_language_string);
        $formatted_client_referer_string         = $this->escapeImpressionLogDelimiters($client_referer_string);
        $formatted_ch_downlink                   = $this->escapeImpressionLogDelimiters($ch_downlink);
        $formatted_ch_viewport_width             = $this->escapeImpressionLogDelimiters($ch_viewport_width);
        $formatted_ch_prefers_color_scheme       = $this->escapeImpressionLogDelimiters($ch_prefers_color_scheme);

        // Build the log message
        $message =
            '➤ '
          . "$message_date ● $formatted_requested_http_method ● $formatted_requested_uri ● $formatted_requested_server_port ● "
          . "$access_level ● $allowed_or_denied ● "
          . "$remote_ip_address ● "
          . "$formatted_session_id_string ● $user_or_guest ● $user_id_string ● "
          . "$formatted_user_agent_string ● "
          . "$formatted_ch_ua ● $formatted_ch_ua_platform ● $formatted_ch_ua_platform_version ● $formatted_ch_ua_mobile ● $formatted_ch_ua_model ● $formatted_ch_ua_architecture ● $formatted_ch_ua_bitness ● "
          . "$formatted_client_accept_language_string ● "
          . "$formatted_client_referer_string ● "
          . "$formatted_ch_downlink ● $formatted_ch_viewport_width ● $formatted_ch_prefers_color_scheme"
        ;

        // Write to the log
        $bytes_written = file_put_contents($filename, $message . PHP_EOL , FILE_APPEND | LOCK_EX);
    }

    /**
     * @param $expression_string
     * @return string
     * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
     */
    public function escapeImpressionLogDelimiters($expression_string): string
    {
        $expression_string = str_replace('➤', '%➤%', $expression_string);
        $expression_string = str_replace('●', '%●%', $expression_string);

        return $expression_string;
    }

    /**
     * @param $expression_string
     * @return string
     * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
     */
    public function unescapeImpressionLogDelimiters($expression_string): string
    {
        $expression_string = str_replace('%➤%', '➤', $expression_string);
        $expression_string = str_replace('%●%', '●', $expression_string);

        return $expression_string;
    }
}