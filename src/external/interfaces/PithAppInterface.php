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



    // Pith App Interface
    // ------------------


    namespace Pith\Framework;


    interface PithAppInterface
    {
        public function whereAmI();
        public function start();
        public function runRoute($module_name, $route_name);
    }