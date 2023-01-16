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
 * Pith Workflow Element (extend)
 * ------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Variables with underscores are ok.
 * @noinspection PhpCastIsUnnecessaryInspection        - Keep type casts for now. TODO
 */


declare(strict_types=1);


namespace Pith\Framework;

use Pith\Framework\Internal\PithAppReferenceTrait;

// ┌────────────────────────────────────────────────────────────────────────┐
// │    PithWorkflowElement                                                 │
// ├────────────────────────────────────────────────────────────────────────┤
// │    +  access_level : string            --- Name of access level        │
// │    +  app          : PithApp reference --- Access to Pith App          │
// │    +  element_type : string            --- Name of workflow element    │
// ├────────────────────────────────────────────────────────────────────────┤
// │    +  checkAccess( )    : void || throws exception                     │
// │    +  getAccessLevel( ) : string                                       │
// └────────────────────────────────────────────────────────────────────────┘

/**
 * Class PithWorkflowElement
 * @package Pith\Framework
 */
class PithWorkflowElement
{
    use PithAppReferenceTrait;

    public string $access_level;
    public string $element_type;


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
            // TODO - Throw exception - Handle it and then - Deny & show the login page

            // If logged in:
            // TODO - Throw exception - Handle it and then - Deny & show the access denied page

            throw new PithException(
                'Pith Framework Exception 4007: Workflow element access denied.',
                4007
            );
        }
    }
}