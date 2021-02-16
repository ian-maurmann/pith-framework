<?php
# ===================================================================
# Copyright (c) 2008-2021 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Pith Route
// ----------

namespace Pith\Framework\Internal;

class PithRoute
{
    public $route_name;
    public $route_type;
    public $use_layout;
    public $layout_app_route_name;
    public $controller_name_with_namespace;
    public $module_object;
    public $module_name_with_namespace;
    public $module_directory_full_path;
    public $view_relative_path;
    public $view_full_path;

    public function whereAmI()
    {
        return "Pith Route";
    }




}