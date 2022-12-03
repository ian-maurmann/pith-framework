<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


/**
 * Pith Conversion (extend)
 * -------------------
 *
 * @noinspection PhpUnused                             - Ignore for now. TODO
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok here.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
 */


declare(strict_types=1);


namespace Pith\Framework;


/**
 * Class PithQuery
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