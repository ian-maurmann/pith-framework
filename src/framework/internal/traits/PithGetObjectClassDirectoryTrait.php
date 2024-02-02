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
 * Pith Get Object Class Directory Trait
 * -------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long trait names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */

declare(strict_types=1);


namespace Pith\Framework\Internal;

use ReflectionClass;
use ReflectionException;

/**
 * Trait PithGetObjectClassDirectoryTrait
 * @package Pith\Framework\Internal
 */
trait PithGetObjectClassDirectoryTrait
{

    /**
     * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
     * @noinspection PhpUnused                             - Ignore being unused for now.
     * @throws ReflectionException
     */
    public function getObjectClassDirectoryFullPath(): string
    {
        $reflection = new ReflectionClass(get_class($this));
        $directory  = dirname($reflection->getFileName());

        return $directory;
    }

    /**
     * @throws ReflectionException
     *
     * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
     *
     */
    public function getObjectClassDirectoryRelativePath(): string
    {
        $reflection = new ReflectionClass(get_class($this));
        $directory  = dirname($reflection->getFileName());

        $working_directory  = getcwd();
        $relative_directory = substr($directory, strlen($working_directory) + 1);

        return $relative_directory;
    }
}