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
 * Pith View Runner for latte views
 * --------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Short method names are ok.
 * @noinspection PhpPropertyOnlyWrittenInspection      - Ignore here, $this->escape will be used in the phtml views.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok here.
 * @noinspection PhpMissingFieldTypeInspection         - Ignore missing types for View Runner
 */


declare(strict_types=1);


namespace Pith\LatteViewAdapter;

use Latte\Engine;
//use Pith\Framework\Internal\PithEscapeUtility;
//use Pith\Framework\PithAppRetriever;
//use Pith\Framework\PithException;
//use Pith\Framework\PithRoute;
use Pith\Framework\Base\PithException;
use Pith\Framework\Base\Utilities\PithEscapeUtility;
use Pith\Framework\PithAppRetriever;
use Pith\Workflow\PithRoute;
use ReflectionException;

/**
 * Class PithLatteViewRunner
 * @package Pith\LatteViewAdapter
 */
class PithLatteViewRunner
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



    protected function dispatchView(){

        // Set vars:
        //extract( (array) $this->variables );

        // Include the view:
        //require $this->path;

        // https://latte.nette.org/en/develop

        // Get Latte
        $latte = new Engine();

        // Add functions
        $latte->addFunction('insertPageTitle', function () {
            $this->insertPageTitle();
        });
        $latte->addFunction('insertMetaDescription', function () {
            $this->insertMetaDescription();
        });
        $latte->addFunction('insertMetaKeywords', function () {
            $this->insertMetaKeywords();
        });
        $latte->addFunction('insertMetaRobots', function (int $indent = 0) {
            $this->insertMetaRobots($indent);
        });
        $latte->addFunction('insertResourceFiles', function (int $indent = 0) {
            $this->insertResourceFiles($indent);
        });
        $latte->addFunction('insertPartial', function (string $route_namespace) {
            $this->insertPartial($route_namespace);
        });
        $latte->addFunction('insertPageContentByRoute', function (PithRoute $content_route) {
            $this->insertPageContent($content_route);
        });
        $latte->addFunction('insertPage', function () {
            $this->insertPageContent($this->content_route);
        });

        // Add type utility functions
        $latte->addFunction('getType', function ($given_variable) {
            return gettype($given_variable);
        });
        $latte->addFunction('isObject', function ($given_variable) {
            return is_object($given_variable);
        });
        $latte->addFunction('isArray', function ($given_variable) {
            return is_array($given_variable);
        });
        $latte->addFunction('isString', function ($given_variable) {
            return is_string($given_variable);
        });
        $latte->addFunction('isBool', function ($given_variable) {
            return is_bool($given_variable);
        });
        $latte->addFunction('isInt', function ($given_variable) {
            return is_int($given_variable);
        });
        $latte->addFunction('isFloat', function ($given_variable) {
            return is_float($given_variable);
        });
        $latte->addFunction('isDouble', function ($given_variable) {
            return is_double($given_variable);
        });



        // cache directory
        $latte->setTempDirectory(PITH_LATTE_CACHE_PATH);

        // view params
        $params = (array) $this->variables;

        // render to output
        $latte->render($this->path, $params);
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


    /**
     * @param string $route_namespace
     * @throws PithException|ReflectionException
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertPartial(string $route_namespace)
    {
        // Get App
        $app = $this->app_retriever->getApp();

        // Insert Partial
        $app->responder->insertPartial($route_namespace);
    }


    /**
     * @param  PithRoute $content_route
     * @throws PithException|ReflectionException
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertPageContent(PithRoute $content_route)
    {
        // Get App
        $app = $this->app_retriever->getApp();

        // Insert Partial
        $app->responder->insertPageContent($content_route);
    }


}