<?php
# ===================================================================
# Copyright (c) 2008-2023 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

/**
 * Pith View Runner for .phtml views
 * ---------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Short method names are ok.
 */


declare(strict_types=1);


namespace Pith\PhtmlViewAdapter2;


/**
 * Class PithPhtmlViewRunner2
 * @package Pith\PhtmlViewAdapter2
 */
class PithPhtmlViewRunner2
{
    protected $app;
    protected $is_layout;
    protected $path;
    protected $variables;
    protected $content_route;


    public function __construct()
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


    /**
     * @param $app
     * @param $is_layout
     * @param $path
     * @param $variables
     * @param $content_route
     */
    public function run($app, $is_layout, $path, $variables, $content_route)
    {
        $this->app           = $app;
        $this->is_layout     = (bool) $is_layout;
        $this->path          = (string) $path;
        $this->variables     = (object) $variables;
        $this->content_route = $content_route;

        $this->dispatchView();
    }


    /** @noinspection PhpIncludeInspection - Needed to run. */
    protected function dispatchView(){

        // Set vars:
        extract( (array) $this->variables );

        // Include the view:
        require $this->path;
    }


}