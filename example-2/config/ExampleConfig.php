<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Example Config
// --------------

namespace Pith\BlueSkyExampleConfig;


class ExampleConfig
{
    private $config_profile;



    function __construct()
    {
        $this->yourConfigSettingsGoHere();
    }




    private function yourConfigSettingsGoHere(){
        $profile = (object)[];

        // Profile:
        $profile->name          = 'Example Config Profile';
        $profile->error_404_url = '/404';
        $profile->error_501_url = '/501';

        $this->config_profile = $profile;
    }



    public function getConfigProfile(){
        return $this->config_profile;
    }



    public function whereAmI()
    {
        return 'Example Config Object';
    }
}