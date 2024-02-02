<?php
# ===================================================================
# Copyright (c) 2008-2024 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

/**
 * Pith View Requisition (extend)
 * ---------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework;


/**
 * Class PithViewRequisition
 * @package Pith\Framework
 */
class PithViewRequisition extends PithWorkflowElement
{
    public    string $element_type     = 'view-requisition';
    public    string $requisition_type = 'view-requisition';
    protected array  $headers          = [];
    protected array  $resources        = [];


    public function provisionViewRequisition()
    {
        $this->headers   = [];
        $this->resources = [];
    }


    /**
     * @param string $human_readable_name
     * @param string $http_header
     * @param bool   $replace
     * @param int    $response_code
     */
    public function addHeader(string $human_readable_name, string $http_header, bool $replace = true, int $response_code = 0)
    {
        $this->headers[] = [
            'name'          => $human_readable_name,
            'http_header'   => $http_header,
            'replace'       => $replace,
            'response_code' => $response_code
        ];
    }


    /**
     * @param string $human_readable_name
     * @param string $filepath
     * @param string $role
     */
    public function addScript(string $human_readable_name, string $filepath, string $role = 'application-for-page')
    {
        // Roles:
        //     'reset'
        //     'library-for-layout'
        //     'application-for-layout'
        //     'library-for-page'
        //     'application-for-page'
        //     'library-for-partial'
        //     'application-for-partial'

        $this->resources[] = [
            'name'          => $human_readable_name,
            'resource_type' => 'script',
            'filepath'      => $filepath,
            'role'          => $role,
        ];

    }

    /**
     * @param string $human_readable_name
     * @param string $filepath
     * @param string $role
     */
    public function addStylesheet(string $human_readable_name, string $filepath, string $role = 'application-for-page')
    {
        // Roles:
        //     'font-preload'
        //     'reset'
        //     'library-for-layout'
        //     'application-for-layout'
        //     'library-for-page'
        //     'application-for-page'
        //     'library-for-partial'
        //     'application-for-partial'
        //     'font-stylesheet'

        $this->resources[] = [
            'name'          => $human_readable_name,
            'resource_type' => 'stylesheet',
            'filepath'      => $filepath,
            'role'          => $role,
        ];
    }

    public function addPreload(string $human_readable_name, string $filepath, string $role = 'preload', string $as = '')
    {
        // Roles:
        //     'font-preload'
        //     'reset'
        //     'preload'
        //     'library-for-layout'
        //     'application-for-layout'
        //     'library-for-page'
        //     'application-for-page'
        //     'library-for-partial'
        //     'application-for-partial'
        //     'font-stylesheet'

        $this->resources[] = [
            'name'          => $human_readable_name,
            'resource_type' => 'preload',
            'filepath'      => $filepath,
            'role'          => $role,
            'as'            => $as,
        ];
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getResources(): array
    {
        return $this->resources;
    }


    public function runRequisition()
    {
        // Do nothing.
    }
}