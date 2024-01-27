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
 * Pith Escape Utility
 * -------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Internal;


/**
 * Class PithEscapeUtility
 * @package Pith\Framework\Internal
 */
class PithEscapeUtility
{
    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     * @param  $unclean_string
     * @return string
     *
     * @noinspection PhpRedundantOptionalArgumentInspection - Specify UTF-8, even if it is (Thankfully) the default now.
     */
    public function html($unclean_string): string
    {
        return htmlspecialchars($unclean_string, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
    }
}