<?php /** @noinspection PhpPropertyNamingConventionInspection */
# ===================================================================
# Copyright (c) 2008-2023 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

/**
 * Pith Active User
 * ----------------
 *
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Long property names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework;



/**
 * Class PithActiveUser
 * @package Pith\Framework
 */
class PithActiveUser
{
    private string $remote_ip_address = '';

    public function __construct()
    {

        $this->remote_ip_address = $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @return string
     */
    public function getRemoteIpAddress(): string
    {
        return $this->remote_ip_address;
    }

}