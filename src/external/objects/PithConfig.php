<?php
# ===================================================================
# Copyright (c) 2008-2020 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Pith Config
// -----------

namespace Pith\Framework;

class PithConfig implements PithConfigInterface
{
    public  $profile;

    private $route_list;

    public function whereAmI()
    {
        return "Pith Config";
    }



    public function setConfigByObject($config_object)
    {
        $this->profile = $config_object->getConfigProfile();
    }

    public function setRouteListByObject($route_list_object)
    {
        $this->route_list = $route_list_object->getRouteList();
    }

    public function getRouteList(){
        return $this->route_list;
    }



}


