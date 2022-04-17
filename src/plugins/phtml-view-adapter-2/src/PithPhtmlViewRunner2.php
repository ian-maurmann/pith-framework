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


// Pith View Runner for .phtml views
// ---------------------------------

namespace Pith\PhtmlViewAdapter2;


class PithPhtmlViewRunner2
{
    protected $app;
    protected $is_layout;
    protected $path;
    protected $variables;
    protected $content_route;

    function __construct()
    {
        $this->reset();
    }

    protected function reset()
    {
        $this->app           = null;
        $this->is_layout     = false;
        $this->path          = null;
        $this->variables     = null;
        $this->content_route = null;
    }


    public function run($app, $is_layout, $path, $variables, $content_route=null)
    {
        $this->app           = $app;
        $this->is_layout     = (bool) $is_layout;
        $this->path          = (string) $path;
        $this->variables     = (object) $variables;
        $this->content_route = $content_route;

        $this->dispatchView();
    }

    protected function dispatchView(){

        // Set vars:
        extract( (array) $this->variables );

        // Include the view:
        require $this->path;
    }
}