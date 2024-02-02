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
 * Pith View Adapter for showing CLI Job output
 * --------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Short method names are ok.
 * @noinspection PhpUnused                             - Will be used by workflow elements.
 */

declare(strict_types=1);

namespace Pith\CliViewAdapter;

use Pith\Framework\Internal\PithTaskLogger;
use Pith\Framework\PithApp;

/**
 * Class PithCliViewAdapter
 * @package Pith\CliViewAdapter
 */
class PithCliViewAdapter
{
    // Objects
    public PithApp $app;
    public $view_runner;
    public PithTaskLogger $task_logger;

    // Vars
    protected $full_path_to_phtml_view;
    protected $object_with_variables;
    protected $is_layout;
    protected $content_route;
    protected $resources;


    public function __construct(PithTaskLogger $task_logger)
    {
        // Default
        $this->reset();

        // Set objects
        $this->task_logger = $task_logger;
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
        $cli_writes = $this->app->cli_writer->getWrites();

        $cli_output = implode("\r\n", $cli_writes);

        if($this->app->config->should_echo_cli_output){
            // Set content type header
            header('Content-type: text/plain; charset=utf-8');

            // Display CLI Output
            echo $cli_output;
        }
        if(PITH_COMMAND_TASK_OUTPUT_LOG_ENABLE){
            $this->task_logger->logTaskOutput($cli_output);
        }
    }
}