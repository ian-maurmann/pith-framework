<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

/**
 * Pith Workflow Element (extend)
 * ------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Variables with underscores are ok.
 */


declare(strict_types=1);


namespace Pith\Framework;

use Pith\Framework\Internal\PithAppReferenceTrait;

/**
 * Class PithWorkflowElement
 * @package Pith\Framework
 */
class PithWorkflowElement
{
    use PithAppReferenceTrait;

    public $access_level = null;
    public $element_type = null;


    /**
     * Get Access Level
     *
     * @return string
     */
    public function getAccessLevel(): string
    {
        return (string) $this->access_level;
    }


    /**
     * @throws PithException
     */
    public function checkAccess()
    {
        // Check access
        $access_level_name = $this->getAccessLevel();
        $is_allowed        = $this->app->access_control->isAllowedToAccess($access_level_name);

        if(!$is_allowed){
            // If not logged in:
            // TODO - Deny & show the login page

            // If logged in:
            // TODO - Deny & show the access denied page

            throw new PithException(
                'Pith Framework Exception 4007: Workflow element access denied.',
                4007
            );
        }
    }
}