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
 * Pass-through Preparer
 * ---------------------
 *
 * @noinspection PhpMissingParentCallCommonInspection - Preparer parent methods exist as fallback.
 * @noinspection PhpClassNamingConventionInspection   - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Internal;

use Pith\Framework\PithPreparer;

/**
 * Class PassThroughPreparer
 * @package Pith\Framework\Internal
 */
class PassThroughPreparer extends PithPreparer
{
    public function runPreparer()
    {
        // Copy the whole Prepare to View unchanged
        $this->view = $this->prepare;
    }
}