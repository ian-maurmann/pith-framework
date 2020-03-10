<?php
# ===================================================================
# Copyright (c) 2008-2020 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Access Control
// -------------------


declare(strict_types=1);


namespace Pith\Framework;


use Pith\Framework\Internal\PithAccessLevelFactory;


class PithAccessControl
{
    private $app;
    private $access_level_factory;
    private $access_levels;

    function __construct(PithAccessLevelFactory $access_level_factory)
    {
        // Objects:
        $this->access_level_factory = $access_level_factory;

        // Initial vars:
        $this->access_levels = [];
    }

    public function init($app)
    {
        $this->app = $app;

        $this->access_level_factory->setApp($app);
    }

    public function isAllowedToAccess($access_level_name)
    {
        $is_allowed          = false;
        $access_level_object = $this->access_level_factory->getAccessLevel($access_level_name);

        if(is_object($access_level_object)) {
            $is_allowed = $access_level_object->isAllowedToAccess();
        }

        return $is_allowed;
    }
}