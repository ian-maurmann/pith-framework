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
 * Pith Workflow Element (extend)
 * ------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Variables with underscores are ok.
 * @noinspection PhpCastIsUnnecessaryInspection        - Keep type casts for now. TODO
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok here.
 */


declare(strict_types=1);


namespace Pith\Framework;


// ┌────────────────────────────────────────────────────────────────────────┐
// │    Workflow Element                                                    │
// ├────────────────────────────────────────────────────────────────────────┤
// │    +  access_level : string | namespace                                │
// │    #  dependency_injection : dependency injection object               │
// │    +  element_type : string                                            │
// ├────────────────────────────────────────────────────────────────────────┤
// │    +  getAccessLevel( ) : string | namespace                           │
// │    +  setDependencyInjection( ) : void                                 │
// └────────────────────────────────────────────────────────────────────────┘

/**
 * Class PithWorkflowElement
 * @package Pith\Framework
 */
class PithWorkflowElement
{
    protected PithDependencyInjection $dependency_injection;

    public string $access_level;
    public string $element_type;


    /**
     * Get Access Level
     * @return string
     */
    public function getAccessLevel(): string
    {
        return (string) $this->access_level;
    }

    /**
     * @param PithDependencyInjection $dependency_injection
     */
    public function setDependencyInjection(PithDependencyInjection $dependency_injection)
    {
        $this->dependency_injection = $dependency_injection;
    }

}