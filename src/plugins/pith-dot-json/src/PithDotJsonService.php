<?php
# ===================================================================
# Copyright (c) 2008-2025 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// pith.json Service
// -----------------

namespace Pith\Framework\Plugin\PithDotJson;


class PithDotJsonService
{
    // Objects
    private $pith_json_gateway;

    // Vars
    private $directory_path;
    private $file_path;


    function __construct(PithDotJsonFileGateway $pith_json_gateway)
    {
        // Add objects
        $this->pith_json_gateway = $pith_json_gateway;
    }

    public function setLocation($directory_location)
    {
        $this->directory_path = $directory_location;
        $this->file_path = $directory_location . '/pith.json';
    }

    public function doesPithDotJsonExist()
    {
        // Forget what files exist / don't exist
        clearstatcache();

        $does_file_exist = file_exists($this->file_path);

        return $does_file_exist;
    }

    public function createNewPithDotJson($app_name, $public_path)
    {
        $data = [
            'app_name' => $app_name,
            'public_path' => $public_path,
        ];

        $json = json_encode($data);

        if(!file_exists($this->file_path)){
            $file_handle = fopen($this->file_path, 'w');

            // todo: replace with write loop, for when fwrite fails
            fwrite($file_handle, $json);

            fclose($file_handle);
        }


    }
}