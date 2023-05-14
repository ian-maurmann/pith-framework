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
 * Pith Expression Utility
 * -----------------------
 *
 * @noinspection PhpClassNamingConventionInspection  - Long class names are ok.
 * @noinspection PhpMethodNamingConventionInspection - Long method names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Internal;


/**
 * Class PithExpressionUtility
 * @package Pith\Framework\Internal
 */
class PithExpressionUtility
{
    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     * @param string $view_path_expression
     * @param string $pack_folder
     * @param string $route_folder
     * @return string
     *
     * @noinspection PhpUnnecessaryLocalVariableInspection - For readability
     */
    public function getViewPathFromExpression(string $view_path_expression, string $pack_folder, string $route_folder): string
    {
        // Process the expression
        $expressed_string = $view_path_expression;
        $expressed_string = str_replace('[^pack_folder]',  $pack_folder,  $expressed_string);
        $expressed_string = str_replace('[^route_folder]', $route_folder, $expressed_string);

        // Expression gives us the view's path
        $view_path = $expressed_string;

        // Return the view path
        return $view_path;
    }
}