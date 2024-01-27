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
 * Pith Conversion (extend)
 * ------------------------
 *
 * Concept:
 * - Based on old 2010s code styles that used Strategy Pattern for data mapping database results to object hydration.
 * - That was a bit hard to picture.
 * - This is simpler.
 *
 * What this does:
 * - Conversion has one function - convert( ).
 * - convert( ) is given an array or object, and creates a new array or object.
 *
 * @noinspection PhpUnused                             - Ignore for now. TODO
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok here.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
 */


declare(strict_types=1);


namespace Pith\Framework;


/**
 * Class PithConversion
 * @package Pith\Framework
 */
class PithConversion
{
    /**
     * @param  object|array $input_data_structure
     * @return object|array
     */
    public function convert(object|array $input_data_structure): object|array
    {
        // Do nothing for now.
        $output_data_structure = $input_data_structure;

        return $output_data_structure;
    }
}