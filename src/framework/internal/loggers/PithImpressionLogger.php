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
     * @param bool $access_success
     * @param string $remote_ip_address
     * @param string $client_ua_string
     * @param string $client_hint_ua_string
     * @param string $client_hint_ua_mobile_string
     * @param string $client_hint_ua_platform_string
     * @param string $client_accept_language_string
     * @param string $client_referer_string
     *
     * @noinspection PhpTooManyParametersInspection - Ignore.
     * @throws PithException
     */
    public function logImpression(
        string $requested_http_method,
        string $requested_uri,
        string $requested_server_port,
        string $access_level,
        bool   $access_success,
        string $remote_ip_address,
        string $client_ua_string,
        string $client_hint_ua_string,
        string $client_hint_ua_mobile_string,
        string $client_hint_ua_platform_string,
        string $client_accept_language_string,

        string $client_referer_string,
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

        // Message
        $allowed_or_denied = ($access_success) ? 'allowed' : 'denied';
        $user_or_guest = 'guest';
        $session_id = '[session id]';
        $user_id = '[user id]';

        $message =
            '➤ '
          . "$message_date ● $requested_http_method ● $requested_uri ● $requested_server_port ● "
          . "$access_level ● $allowed_or_denied ● "
          . "$remote_ip_address ● "
          . "$session_id ● $user_or_guest ● $user_id ● "
          . "$client_ua_string ● $client_hint_ua_string ● $client_hint_ua_mobile_string ● $client_hint_ua_platform_string ● $client_accept_language_string ● "
          . "$client_referer_string";



        $bytes = file_put_contents($filename, $message . PHP_EOL , FILE_APPEND | LOCK_EX);
    }
}