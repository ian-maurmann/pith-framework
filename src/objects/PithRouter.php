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


// Pith Router
// -----------

namespace Pith\Framework;

class PithRouter implements PithRouterInterface
{
    public function whereAmI()
    {
        return "Pith Router";
    }

    public function findRoute(string $route_name)
    {
        // TODO: Implement findRoute() method.
    }
}