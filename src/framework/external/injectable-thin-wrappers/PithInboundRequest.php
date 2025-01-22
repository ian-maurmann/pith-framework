<?php
# ===================================================================
# Copyright (c) 2008-2025 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

/**
 * Pith Inbound Request - Thin wrapper to pass the request around
 * --------------------------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class PithInboundRequest
 * @package Pith\Framework
 */
class PithInboundRequest
{
    public Request $request;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
    }
}