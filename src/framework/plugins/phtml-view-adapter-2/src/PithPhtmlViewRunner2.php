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
 * @noinspection PhpPropertyOnlyWrittenInspection      - Ignore here, $this->escape will be used in the phtml views.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok here.
 */


declare(strict_types=1);


namespace Pith\PhtmlViewAdapter2;


use Pith\Framework\Internal\PithEscapeUtility;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;

/**
 * Class PithPhtmlViewRunner2
 * @package Pith\PhtmlViewAdapter2
 */
class PithPhtmlViewRunner2
{
    private PithEscapeUtility $escape;
    private PithAppRetriever  $app_retriever;

    protected $app;
    protected $is_layout;
    protected $path;
    protected $variables;
    protected $content_route;



    public function __construct(PithEscapeUtility $escape, PithAppRetriever $app_retriever)
    {
        // Object Dependencies
        $this->escape        = $escape;
        $this->app_retriever = $app_retriever;

        // Reset
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



    /**
     * @throws PithException
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertPageTitle()
    {
        // Get App
        $app = $this->app_retriever->getApp();

        // Insert Page Title
        $app->responder->insertPageTitle();
    }



    /**
     * @throws PithException
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertMetaDescription()
    {
        // Get App
        $app = $this->app_retriever->getApp();

        // Insert Meta Description
        $app->responder->insertMetaDescription();
    }



    /**
     * @throws PithException
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertMetaKeywords()
    {
        // Get App
        $app = $this->app_retriever->getApp();

        // Insert Meta Keywords
        $app->responder->insertMetaKeywords();
    }



    /**
     * @param int $indent
     * @throws PithException
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertMetaRobots(int $indent = 0){
        // Get App
        $app = $this->app_retriever->getApp();

        // Insert Meta Keywords
        $app->responder->insertMetaRobots($indent);
    }


    /**
     * @param int $indent
     * @throws PithException
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertResourceFiles(int $indent = 0)
    {
        // Get App
        $app = $this->app_retriever->getApp();

        // Insert Meta Keywords
        $app->responder->insertResourceFiles($indent);
    }


}