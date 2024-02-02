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
 * 'dev-ip' Access Level
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
 * Class DevIpAccessLevel
 * @package Pith\Framework\Internal
 */
class DevIpAccessLevel extends PithAccessLevel
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

        // Get array of allowed IPs
        $allowed_ips = PITH_DEV_ACCESS_IP_ADDRESSES;

        // Get the user/guest's IP
        $user_or_guest_ip = $app->active_user->getRemoteIpAddress();

        // See if the IP is inside the list of allowed IPs
        if(is_array($allowed_ips)){
            if(in_array($user_or_guest_ip, $allowed_ips)){
                $is_allowed = true;
            }
        }

        return $is_allowed;
    }
}