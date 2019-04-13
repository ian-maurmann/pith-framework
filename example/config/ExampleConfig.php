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


// Example Config
// --------------

namespace Pith\ExampleConfig;


class ExampleConfig
{
    private $config_profile;



    function __construct()
    {
        $this->yourConfigSettingsGoHere();
    }




    private function yourConfigSettingsGoHere(){
        $new_config_profile = (object)[];

        // Config Profile Name
        $new_config_profile->name = 'Example Config Profile';

        $this->config_profile = $new_config_profile;
    }



    public function getConfigProfile(){
        return $this->config_profile;
    }



    public function whereAmI()
    {
        return 'Example Config Object';
    }
}