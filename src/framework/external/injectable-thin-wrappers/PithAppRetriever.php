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
 * Pith App Retriever
 * ------------------
 * - Thin wrapper to get the App object in local scope,
 *   without creating circular dependencies for our
 *   poor, hard-working PHP-DI container to deal with.
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are needed here.
 */


declare(strict_types=1);

namespace Pith\Framework;


/**
 * Class PithAppRetriever
 * @package Pith\Framework
 */
class PithAppRetriever
{
    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     * @return PithApp
     * @throws PithException
     */
    public function getApp(): PithApp
    {
        // Ugly, but should work until next re-write
        global $pith;

        // Throw if $pith is not set yet
        $is_app_object = ($pith instanceof PithApp);
        if(!$is_app_object){
            throw new PithException(
                'Pith Framework Exception 5010: The Pith Framework App variable is not a Pith App Object',
                5010
            );
        }

        // Return the App object
        return $pith;
    }
}