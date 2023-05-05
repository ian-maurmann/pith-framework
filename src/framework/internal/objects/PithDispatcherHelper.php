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
 * Pith Dispatcher Helper
 * ----------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\Internal;


use Pith\Framework\PithException;

/**
 * Class PithDispatcherHelper
 * @package Pith\Framework\Internal
 */
class PithDispatcherHelper
{
    public function __construct()
    {
        // Do nothing for now
    }


    /**
     * @param  string $real_resource_folder_path
     * @throws PithException
     */
    public function ensureRealResourceFolderIsADirectory(string $real_resource_folder_path)
    {
        // Check that the Real Resource Folder is a directory
        $is_real_resource_folder_path_a_folder = ($real_resource_folder_path && is_dir($real_resource_folder_path));
        if(!$is_real_resource_folder_path_a_folder){
            throw new PithException(
                'Pith Framework Exception 4021: Resource folder must be a folder.',
                4021
            );
        }
    }



    /**
     * @param  string|mixed $real_filepath
     * @throws PithException
     */
    public function ensureRealFilepathIsAFile(mixed $real_filepath)
    {
        // Check that the Real Filepath is a file
        $is_real_filepath_a_file = ($real_filepath && is_file($real_filepath));
        if(!$is_real_filepath_a_file){
            throw new PithException(
                'Pith Framework Exception 4022: Resource file must be a file.',
                4022
            );
        }
    }
    

    /**
     * @param  string $real_filepath
     * @param  string $real_resource_folder_path
     * @throws PithException
     */
    public function ensureRealFilepathIsInsideRealResourceFolder(string $real_filepath, string $real_resource_folder_path)
    {
        // Check that the Real Filepath is really inside the Real Resource Folder
        $is_real_filepath_inside_resource_folder = str_starts_with($real_filepath, $real_resource_folder_path . DIRECTORY_SEPARATOR);
        if(!$is_real_filepath_inside_resource_folder){
            throw new PithException(
                'Pith Framework Exception 4020: Requested Resource outside of Resource folder.',
                4020
            );
        }
    }



    /**
     * @param  string $basename
     * @param  string $real_filepath
     * @throws PithException
     */
    public function ensureFilenameIsNotDotFile(string $basename, string $real_filepath)
    {
        // Don't serve dot files
        $starts_with_dot_file = (substr($basename, 0, 1) === '.');
        $has_sub_dot_file     = str_contains($real_filepath, DIRECTORY_SEPARATOR . '.');
        $has_dot_file         = $starts_with_dot_file || $has_sub_dot_file;
        if($has_dot_file){
            throw new PithException(
                'Pith Framework Exception 4023: Requested Resource path includes a dot file.',
                4023
            );
        }
    }



    /**
     * @param  string $basename
     * @return string
     * @throws PithException
     */
    public function getResourceFileExtension(string $basename): string
    {
        // Get extension
        $file_extension = pathinfo($basename, PATHINFO_EXTENSION);

        // Extensions to just block outright
        $extensions_to_block = [
            'cgi',
            'inc',
            'ini',
            'log',
            'perl',
            'php',
            'php3',
            'php4',
            'php5',
            'phtml',
            'pl',
            'PL',
            'pm',
            'py',
            'pyc',
            'pyo',
            'pyw',
            'pyz',
            's',
            'S',
            'sh',
            'so',
        ];

        // Check if we should complain here
        $is_extension_to_block = isset($extensions_to_block[$file_extension]);

        // Throw exception for putting an executable file type in the resource folder
        if($is_extension_to_block){
            throw new PithException(
                'Pith Framework Exception 4029: Requested Resource is a file type that should not be inside the resource folder.',
                4029
            );
        }

        return $file_extension;
    }



    /**
     * @param string $real_filepath
     * @param string $file_extension
     */
    public function setResourceHeadersByExtension(string $real_filepath, string $file_extension)
    {
        // Content types
        $extensions_to_content_types = [
            'apng'  => 'Content-Type: image/apng',
            'atom'  => 'Content-Type: application/atom+xml',
            'avif'  => 'Content-Type: image/avif',
            'bmp'   => 'Content-Type: image/bmp',
            'css'   => 'Content-type: text/css; charset=utf-8',
            'csv'   => 'Content-type: text/csv; charset=utf-8',
            'gif'   => 'Content-Type: image/gif',
            'gz'    => 'Content-Type: application/gzip',
            'html'  => 'Content-type: text/html; charset=utf-8',
            'ico'   => 'Content-Type: image/x-icon',
            'jpeg'  => 'Content-Type: image/jpeg',
            'jpg'   => 'Content-Type: image/jpeg',
            'js'    => 'Content-type: text/javascript; charset=utf-8',
            'json'  => 'Content-type: application/json; charset=utf-8',
            'md'    => 'Content-type: text/markdown; charset=utf-8',
            'mpeg'  => 'Content-Type: audio/mpeg',
            'mp4'   => 'Content-Type: video/mp4',
            'ogg'   => 'Content-Type: application/ogg',
            'otf'   => 'Content-Type: font/otf',
            'pdf'   => 'Content-Type: application/pdf',
            'png'   => 'Content-Type: image/png',
            'rar'   => 'Content-Type: application/vnd.rar, application/x-rar-compressed, application/octet-stream',
            'rss'   => 'Content-Type: application/rss+xml; charset=utf-8',
            'svg'   => 'Content-Type: image/svg+xml',
            'tar'   => 'Content-Type: application/x-tar',
            'tif'   => 'Content-Type: image/tiff',
            'tiff'  => 'Content-Type: image/tiff',
            'ttf'   => 'Content-Type: font/ttf',
            'TTF'   => 'Content-Type: font/ttf',
            'txt'   => 'Content-type: text/plain; charset=utf-8',
            'wav'   => 'Content-Type: audio/wav',
            'webp'  => 'Content-Type: image/webp',
            'woff'  => 'Content-Type: font/woff',
            'woff2' => 'Content-Type: font/woff2',
            'xml'   => 'Content-type: text/xml',
            'zip'   => 'Content-Type: application/zip',
        ];


        // Set content-type headers by extension
        if (isset($extensions_to_content_types[$file_extension])) {
            header($extensions_to_content_types[$file_extension], true);
        } else {
            // Apache > 2.2.7 reported 'text/plain' or 'application/octet-stream' for unknown content types.
            // Apache reports 'none' for files with unknown content types.
            // Nginx reports 'text/plain' for unknown content types.

            // We're going to go with 'none' here
            header('Content-type: none; charset=utf-8', true);
        }


        // Extensions that need size check
        $extensions_that_require_size = [
            'apng',
            'avif',
            'bmp',
            'gif',
            'gz',
            'ico',
            'jpeg',
            'jpg',
            'mpeg',
            'mp4',
            'ogg',
            'otf',
            'pdf',
            'png',
            'rar',
            'tar',
            'tif',
            'tiff',
            'ttf',
            'TTF',
            'wav',
            'webp',
            'woff',
            'woff2',
            'zip',
        ];

        // Set file size headers
        if (isset($extensions_that_require_size[$file_extension])) {
            $file_byte_size = filesize($real_filepath);

            header("Content-length: $file_byte_size");
        }
    }
}