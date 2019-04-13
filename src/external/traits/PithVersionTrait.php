<?php
# ===================================================================
# Copyright (c) 2009-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================
declare(strict_types=1);



    // Pith Version Trait
    // ------------------


    namespace Pith\Framework;


    trait PithVersionTrait
    {
        public function version()
        {
            return "Pith Framework: rv 0.6.0.2 sv 0.3.0";
        }
    }