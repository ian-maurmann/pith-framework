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
 * Pith App Reference Trait
 * ------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long trait names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */

declare(strict_types=1);


namespace Pith\Framework\Internal;


use Pith\Framework\PithApp;


/**
 * Trait PithAppReferenceTrait
 * @package Pith\Framework\Internal
 */
trait PithAppReferenceTrait
{
    /**
     * @var PithApp $app
     */
    public PithApp $app;

    
    /**
     * Sets the reference to the App object.
     *
     * @param PithApp $app
     *
     * @noinspection PhpUnused - Used by PithAppHelper::initializeDependencies( ).
     */
    public function setAppReference(PithApp $app)
    {
        $this->app = $app;
    }
}