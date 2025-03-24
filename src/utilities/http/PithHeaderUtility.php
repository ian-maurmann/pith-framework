<?php

# ===================================================================
# Copyright (c) 2008-2025 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


/**
 * Pith Header Utility
 * -------------------
 *
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok here.
 * @noinspection PhpUnnecessaryLocalVariableInspection - Readability
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\Utility;


/**
 * Class PithHeaderUtility
 */
class PithHeaderUtility
{
    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     * @return bool
     */
    private function isCgi(): bool
    {
        $sapi_type = php_sapi_name();
        $is_cgi = str_starts_with($sapi_type, 'cgi');

        // Return true if we're running on CGI, else false
        return $is_cgi;
    }

    public function httpStatusCode207MultiStatus(): void
    {
        if ($this->isCgi()){
            header('Status: 207 Multi-Status');
        }
        else{
            header('HTTP/1.1 207 Multi-Status');
        }

    }

    public function httpStatusCode404NotFound(): void
    {
        if ($this->isCgi()){
            header('Status: 404 Not Found');
        }
        else {
            header('HTTP/1.1 404 Not Found');
        }

    }
}