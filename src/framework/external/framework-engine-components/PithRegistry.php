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
 * Pith Registry
 * -------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework;

/**
 * Class PithRegistry
 * @package Pith\Framework
 */
class PithRegistry
{
    public string $access_level_note     = '';
    public string $requested_uri         = '';
    public string $requested_http_method = '';


    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     * @return string
     */
    public function getRequestedUri(): string
    {
        return $this->requested_uri;
    }

}