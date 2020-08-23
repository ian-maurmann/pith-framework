<?php
# ===================================================================
# Copyright (c) 2008-2020 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith State Enum
// ---------------


declare(strict_types=1);


namespace Pith\Framework\Internal;


use MyCLabs\Enum\Enum;


class PithStateEnum extends Enum
{
    private const INITIALIZED = "initialized";
    private const ROUTING     = "routing";
    private const DISPATCHING = "dispatching";
}
