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
 * Random Char Utility
 * -------------------
 *
 * @noinspection PhpClassNamingConventionInspection     - Long class name is ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection  - Ignore for readability.
 * @noinspection PhpVariableNamingConventionInspection  - Long variable names are ok.
 * @noinspection PhpMethodNamingConventionInspection    - Long method names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\Random;

use Exception;

/**
 * Class RandomCharUtility
 * @package Pith\Framework\SharedInfrastructure\Model\Random
 */
class RandomCharUtility
{
    /**
     * @throws Exception
     */
    public function pickRandomChar($possible_chars): string
    {
        $max         = mb_strlen($possible_chars) - 1;
        $random_int  = random_int(0, $max);
        $random_char = substr($possible_chars,$random_int, 1);

        return $random_char;
    }

    /**
     * @return string
     * @throws Exception
     * @noinspection SpellCheckingInspection
     */
    public function getRandomCheckCharVersion1(): string
    {
        $possible_chars = 'ACDEFGHJKMNPRSTUVWXYZ'; // Alphabet letters except B,I,L,O,Q
        $random_char    = $this->pickRandomChar($possible_chars);

        return $random_char;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getRandomCheckCharVersion1Lower(): string
    {
        return mb_strtolower( $this->getRandomCheckCharVersion1() );
    }

}