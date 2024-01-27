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
 * Pith Adapter for Json Endpoints
 * -------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Short method names are ok.
 * @noinspection PhpUnused                             - Will be used by workflow elements.
 */

declare(strict_types=1);

namespace Pith\JsonEndpointViewAdapter;

use Pith\Framework\PithApp;

/**
 * Class PithJsonEndpointViewAdapter
 * @package Pith\JsonEndpointViewAdapter
 */
class PithJsonEndpointViewAdapter
{
    // Objects
    public $app;
    public $view_runner;

    // Vars
    protected $full_path_to_phtml_view;
    protected $object_with_variables;
    protected $is_layout;
    protected $content_route;
    protected $resources;


    public function __construct()
    {
        // default
        $this->reset();
    }

    public function reset()
    {
        // default
        $this->is_layout = false;
        $this->content_route = null;
        $this->full_path_to_phtml_view = null;
        $this->object_with_variables = null;
        $this->resources = [];
    }


    /**
     * @param PithApp $app
     */
    public function setApp(PithApp $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $full_path_to_phtml_view
     */
    public function setFilePath(string $full_path_to_phtml_view)
    {
        $this->full_path_to_phtml_view = $full_path_to_phtml_view;
    }


    /**
     * @param $view_variables
     */
    public function setVars($view_variables)
    {
        $this->object_with_variables = $view_variables;
    }


    /**
     * @param bool $is_layout
     */
    public function setIsLayout(bool $is_layout){
        $this->is_layout = $is_layout;
    }

    /**
     * @param $content_route
     */
    public function setContentRoute($content_route){
        $this->content_route = $content_route;
    }

    /**
     * @param array $resources
     */
    public function setResources(array $resources)
    {
        $this->resources = $resources;
    }

    public function run()
    {
        // Set content type header
        header('Content-type: application/json; charset=utf-8');

        // Check for response
        $has_response = property_exists($this->object_with_variables, 'response');


        if($has_response){
            // Get the response
            $response = $this->object_with_variables->response;
        }
        else{
            // Give a 500
            http_response_code(500);

            // Build error response body
            $response = [
                'status' => 'error',
                'data'   => [
                    'problem' => 'no response set',
                ],
            ];
        }

        // Output the response
        echo json_encode($response, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);
    }
}