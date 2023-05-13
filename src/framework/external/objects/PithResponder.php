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
 * Pith Responder
 * --------------
 *
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Long property names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework;

use ReflectionException;


/**
 * Class PithResponder
 * @package Pith\Framework
 */
class PithResponder
{
    private PithEngine     $engine;

    private array $resource_files = [];
    private array $resource_files_inserted = [];

    private string $page_title = '';
    private string $meta_keywords = '';
    private string $meta_description = '';
    private string $meta_robots = '';

    public function __construct(PithEngine $engine)
    {
        // Object Dependencies
        $this->engine = $engine;

        // Reset
        $this->reset();
    }

    private function reset()
    {
        $this->resource_files = [];
        $this->resource_files_inserted = [];
    }


    /**
     * @param  string $route_namespace
     * @throws PithException
     * @throws ReflectionException
     *
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertPartial(string $route_namespace)
    {
        $this->engine->runPartial($route_namespace);
    }


    /**
     * @param  string $layout_namespace
     * @throws PithException|ReflectionException
     *
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function runLayout(string $layout_namespace)
    {
        $this->engine->runLayout($layout_namespace);
    }


    /**
     * @param  PithRoute $content_route
     * @throws PithException|ReflectionException
     *
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertPageContent(PithRoute $content_route)
    {
        $this->engine->runPageContent($content_route);
    }

    /**
     * @param int   $indent
     *
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertResourceFiles(int $indent = 0)
    {
        // Roles:
        //     'reset'
        //     'library-for-layout'
        //     'application-for-layout'
        //     'library-for-page'
        //     'application-for-page'
        //     'library-for-partial'
        //     'application-for-partial'

        $resource_files = $this->resource_files;

        $this->insertResourceFilesByRole('CSS Resets',                        $resource_files, 'reset',                   $indent);
        $this->insertResourceFilesByRole('Library Resources for Layout',      $resource_files, 'library-for-layout',      $indent);
        $this->insertResourceFilesByRole('Library Resources for Page',        $resource_files, 'library-for-page',        $indent);
        $this->insertResourceFilesByRole('Library Resources for Partial',     $resource_files, 'library-for-partial',     $indent);
        $this->insertResourceFilesByRole('Application Resources for Layout',  $resource_files, 'application-for-layout',  $indent);
        $this->insertResourceFilesByRole('Application Resources for Page',    $resource_files, 'application-for-page',    $indent);
        $this->insertResourceFilesByRole('Application Resources for Partial', $resource_files, 'application-for-partial', $indent);
    }

    /**
     * @param string $heading_comment_message
     * @param array  $resource_files
     * @param string $role_to_insert
     * @param int    $indent
     */
    public function insertResourceFilesByRole(string $heading_comment_message, array $resource_files, string $role_to_insert, int $indent = 0)
    {
        $is_first = true;
        foreach ($resource_files as $resource_file){
            // Extract variables
            $file_type           = $resource_file['resource_type'];
            $file_path           = $resource_file['filepath'];
            $file_role           = $resource_file['role'];
            $is_already_inserted = in_array($file_path, $this->resource_files_inserted);
            $is_role_to_insert   = $file_role === $role_to_insert;
            $is_to_be_added      = $is_role_to_insert && !$is_already_inserted;

            if($is_to_be_added){
                if($is_first){
                    $indent_string = $this->indent($indent);
                    $comment       = $indent_string . '<!-- ' . $heading_comment_message . ' -->' . "\r\n";

                    echo "\r\n";
                    echo $comment;

                    $is_first = false;
                }
                if($file_type === 'script'){
                    $this->insertScript($file_path, $indent);
                }
                elseif($file_type === 'stylesheet'){
                    $this->insertStylesheet($file_path, $indent);
                }
            }
        }
    }


    /**
     * @param  int $indent
     * @return string
     */
    private function indent(int $indent = 0): string
    {
        return str_repeat(' ',$indent * 4);
    }


    /**
     * @param string $file_path
     * @param int $indent
     */
    private function insertScript(string $file_path, int $indent = 0)
    {
        $indent_string = $this->indent($indent);
        $tag           = '<script src="' . $file_path . '"></script>';

        // Insert script
        echo $indent_string . $tag  . "\r\n";

        // Add to list of files inserted
        $this->resource_files_inserted[] = $file_path;
    }

    /**
     * @param string $file_path
     * @param int $indent
     */
    private function insertStylesheet(string $file_path, int $indent = 0)
    {
        $indent_string = $this->indent($indent);
        $tag           = '<link rel="stylesheet" href="' . $file_path . '">';

        // Insert Stylesheet
        echo $indent_string . $tag . "\r\n";

        // Add to list of files inserted
        $this->resource_files_inserted[] = $file_path;
    }

    /**
     * @param array $resource_files_array
     */
    public function addResourceFiles(array $resource_files_array)
    {
        $old_resource_files   = $this->resource_files;
        $this->resource_files = array_merge($old_resource_files, $resource_files_array);
    }

    /**
     * @param string $page_title
     * @param string $meta_keywords
     * @param string $meta_description
     */
    public function setPageMetadata(string $page_title, string $meta_keywords, string $meta_description, string $meta_robots)
    {
        $this->page_title       = $page_title;
        $this->meta_keywords    = $meta_keywords;
        $this->meta_description = $meta_description;
        $this->meta_robots      = $meta_robots;
    }

    public function insertPageTitle()
    {
        echo $this->page_title;
    }


    /**
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertMetaKeywords()
    {
        echo $this->meta_keywords;
    }

    public function insertMetaDescription()
    {
        echo $this->meta_description;
    }
    
    /**
     * @param int $indent
     *
     * @noinspection PhpUnused - Method will be used by views.
     */
    public function insertMetaRobots(int $indent = 0){
        if(!empty($this->meta_robots)){
            $indent_string = $this->indent($indent);
            $tag = '<meta name="robots" content="' . $this->meta_robots . '">';

            // Insert
            echo '<!-- Robots -->' . "\r\n" . $indent_string . $tag;
        }
    }
}