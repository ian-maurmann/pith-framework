<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Access Level Factory
// -------------------------


declare(strict_types=1);


namespace Pith\Framework\Internal;


class PithAccessLevelFactory
{
    private $app;


    function __construct()
    {
        // Do nothing for now.
    }

    public function setApp($app)
    {
        $this->app = $app;
    }

    public function getAccessLevel($access_level_name)
    {
        $access_level = false;

        if($access_level_name === 'none'){
            // TODO
        }
        elseif($access_level_name === 'world'){
            $access_level = $this->app->container->get('\\Pith\\InternalAccessLevels\\PithWorldAccessLevel');
        }


        if(is_object($access_level)){
            $access_level->setApp($this->app);
        }

        return $access_level;
    }
}