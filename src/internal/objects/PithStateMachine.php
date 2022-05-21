<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith State Machine
// ------------------


declare(strict_types=1);


namespace Pith\Framework\Internal;


class PithStateMachine
{
    use PithAppReferenceTrait;

    private $state;
    private $state_enum;


    function __construct(PithStateEnum $state_enum)
    {
        // Add objects
        $this->state_enum = $state_enum;

        // Initial values
        $this->state = $this->state_enum::INITIALIZED();
    }

}
