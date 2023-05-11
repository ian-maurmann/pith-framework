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
 * Pith Outbound Response - Thin wrapper to pass the Responder around
 * --------------------------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework;


/**
 * Class PithOutboundResponse
 * @package Pith\Framework
 */
class PithOutboundResponse
{
    public PithResponder $responder;

    public function __construct(PithResponder $responder)
    {
        $this->responder = $responder;
    }
}