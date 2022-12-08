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
 * Pith Converter
 * --------------
 *
 * Concept:
 * - Based on old 2010s code styles that used Strategy Pattern for data mapping database results to object hydration.
 * - That was a bit hard to picture.
 * - This is simpler.
 *
 * What this does:
 * - Conversion has two functions - convertOne( ) and convertMany( ).
 * - convertOne( ) is given a Conversion object, and an array/object to convert. Returns a converted array/object.
 * - convertMany( ) is given a Conversion object, and an array of arrays/objects. Converts each array/object in the array.
 *
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok here.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
 * @noinspection PhpPureAttributeCanBeAddedInspection  - Ignore Pure for now, Functionality not set in stone yet.
 */


declare(strict_types=1);


namespace Pith\Framework;


/**
 * Class PithConverter
 * @package Pith\Framework
 */
class PithConverter
{

    /**
     * @param  PithConversion $conversion
     * @param  object|array   $input_data_structure
     * @return object|array
     */
    public function convertOne(PithConversion $conversion, object|array $input_data_structure): object|array
    {
        // Get converted data-structure
        $output_data_structure = $conversion->convert($input_data_structure);

        // Return the converted data-structure
        return $output_data_structure;
    }



    /**
     * @param  PithConversion $conversion
     * @param  array          $input_data_structures
     * @return array
     */
    public function convertMany(PithConversion $conversion, array $input_data_structures): array
    {
        // Start with empty output array
        $output_data_structures = [];

        // Loop through the input array and convert each
        foreach ($input_data_structures as $input_data_structure){
            $output_data_structures[] = $this->convertOne($conversion, $input_data_structure);
        }

        // Return an array of converted data-structures
        return $output_data_structures;
    }

}