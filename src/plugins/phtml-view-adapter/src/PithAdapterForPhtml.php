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


// Pith Adapter for .phtml views
// -----------------------------

namespace Pith\Framework\Adapter\Phtml;


class PithAdapterForPhtml
{
    // Objects
    public $app;
    public $view_runner;

    // Vars
    protected $full_path_to_phtml_view;
    protected $object_with_variables_for_phtml_view;
    protected $is_layout;
    protected $content_route;


    function __construct(PithViewRunnerForPhtml $view_runner)
    {
        // objects
        $this->view_runner = $view_runner;

        // default
        $this->reset();
    }

    public function reset()
    {
        // default
        $this->is_layout = false;
        $this->content_route = null;
        $this->full_path_to_phtml_view = null;
        $this->object_with_variables_for_phtml_view = null;
    }


    public function setApp($app)
    {
        $this->app = $app;
    }

    public function setFilePath($full_path_to_phtml_view)
    {
        $this->full_path_to_phtml_view = $full_path_to_phtml_view;
    }


    public function setVars($view_variables)
    {
        $this->object_with_variables_for_phtml_view = $view_variables;
    }


    public function setIsLayout($is_layout){
        $this->is_layout = $is_layout;
    }

    public function setContentRoute($content_route){
        $this->content_route = $content_route;
    }

    public function run()
    {
        $view_runner = clone $this->view_runner;

        $view_runner->run($this->app, $this->is_layout, $this->full_path_to_phtml_view, $this->object_with_variables_for_phtml_view, $this->content_route);
    }
}