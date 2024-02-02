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
 * Pith Action (extend)
 * ---------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework;

// ┌──────────────────────────────────────────────────────────────────────────┐
// │    Action                                                                │
// ├──────────────────────────────────────────────────────────────────────────┤
// │    +  access_level : string | namespace                                  │
// │    #  dependency_injection : dependency injection object                 │
// │    +  element_type : string 'action'                                     │
// │    #  prepare      : public property object                              │
// ├──────────────────────────────────────────────────────────────────────────┤
// │    +  getAccessLevel( ) : string | namespace                             │
// │    +  getVariablesForPrepare( ) : object                                 │
// │    +  provisionAction( )        : void                                   │
// │    +  runAction( )              : void                                   │
// │    +  setDependencyInjection( ) : void                                   │
// └──────────────────────────────────────────────────────────────────────────┘

/**
 * Class PithAction
 * @package Pith\Framework
 */
class PithAction extends PithWorkflowElement
{
    public string $element_type = 'action';

    protected object $prepare;

    
    public function provisionAction()
    {
        $this->prepare = (object)[];
    }


    /**
     * @return object
     */
    public function getVariablesForPrepare(): object
    {
        return $this->prepare;
    }


    public function runAction()
    {
        // Do nothing
    }
}