<?php
# ===================================================================
# Copyright (c) 2008-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Pith Request Processor
// ----------------------

namespace Pith\Framework;

use Pith\Framework\Internal\PithRequestHelper;
use Pith\Framework\Internal\PithStringUtility;

class PithRequestProcessor
{
    private $app;
    private $helper;
    private $string_utility;
    private $request_uri;   //   /hello/world?foo=5&bar=7
    private $request_path;  //   /hello/world
    private $request_query; //                foo=5&bar=7

    function __construct(PithRequestHelper $request_helper, PithStringUtility $string_utility)
    {
        $this->helper         = $request_helper;
        $this->string_utility = $string_utility;
    }

    public function whereAmI()
    {
        return "Pith Request";
    }


    public function init($app)
    {
        $this->app = $app;
        $this->build();
    }

    public function build()
    {
        $uri_string    = (string) $_SERVER['REQUEST_URI'];
        $uri_parts     = $this->helper->breakUriIntoPathAndQuery($uri_string);
        $request_path  = (string) $uri_parts[0];
        $request_query = (string) $uri_parts[1];

        $this->request_uri   = $uri_string;
        $this->request_path  = $request_path;
        $this->request_query = $request_query;
    }

    /**
     * @return string
     */
    public function getRequestUri()
    {
        return $this->request_uri;
    }

    /**
     * @return string
     */
    public function getRequestPath()
    {
        return $this->request_path;
    }

    /**
     * @return string
     */
    public function getRequestQuery()
    {
        return $this->request_query;
    }


}