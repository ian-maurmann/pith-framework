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
// │    PithAction                                                            │
// ├──────────────────────────────────────────────────────────────────────────┤
// │    +  access_level : string                 --- Name of access level     │
// │    +  app          : PithApp reference      --- Access to Pith App       │
// │    +  element_type : string 'action'        --- Name of workflow element │
// │    #  prepare      : public property object --- Vars to give to preparer │
// ├──────────────────────────────────────────────────────────────────────────┤
// │    +  checkAccess( )            : void || throws exception               │
// │    +  getAccessLevel( )         : string                                 │
// │    +  getVariablesForPrepare( ) : public property object                 │
// │    +  provisionAction( )        : void                                   │
// │    +  runAction( )              : void                                   │
// └──────────────────────────────────────────────────────────────────────────┘

/**
 * Class PithAction
 * @package Pith\Framework
 */
class PithAction extends PithWorkflowElement
{
    public    $element_type = 'action';
    protected $prepare      = null;

    public function provisionAction()
    {
        $this->prepare = (object)[];
    }

    /**
     * @return null|object
     */
    public function getVariablesForPrepare()
    {
        return $this->prepare;
    }

    public function runAction()
    {
        // Do nothing
    }
}