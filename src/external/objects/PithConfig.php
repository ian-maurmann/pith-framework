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


// Pith Config
// -----------

namespace Pith\Framework;

class PithConfig implements PithConfigInterface
{
    public  $profile;
    private $config_file_path;

    public function whereAmI()
    {
        return "Pith Config";
    }

    public function setConfigFileLocation($path_to_config_file)
    {
        $this->config_file_path = $path_to_config_file;
    }

    public function loadConfig(){
        $this->profile = $this->executeConfigFile();
    }

    private function executeConfigFile()
    {
        $config_profile = (object)[];

        require $this->config_file_path;

        return $config_profile;
    }
}

