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
 * 'webmaster' Access Level
 * ------------------------
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
 * Class WebmasterAccessLevel
 * @package Pith\Framework\Internal
 */
class WebmasterAccessLevel extends PithAccessLevel
{
    private PithAppRetriever $app_retriever;

    public function __construct(PithAppRetriever $app_retriever){
        // Set object dependencies
        $this->app_retriever = $app_retriever;
    }

    /**
     * @throws PithException
     */
    public function isAllowedToAccess(): bool
    {
        // "webmaster" access;

        // Default to deny access
        $is_allowed = false;

        // Get the app
        $app = $this->app_retriever->getApp();

        // Get if the visitor has user access, or higher
        $is_user = $app->active_user->isUser();

        // Allow if is user
        if($is_user){
            $is_webmaster = $app->active_user->isWebmaster();

            $is_allowed = $is_webmaster;
        }

        return $is_allowed;
    }
}