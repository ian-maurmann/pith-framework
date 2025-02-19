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
 * Random Token Utility
 * --------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection - Ignore for readability.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4 not PSR-0.
 * @noinspection PhpPropertyNamingConventionInspection - Properties with underscores are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\Random;

use Exception;
use Pith\Framework\Plugin\GroupingUtility\GroupingUtility;

/**
 * Class RandomTokenUtility
 * @package Pith\Framework\SharedInfrastructure\Model\Random
 */
class RandomTokenUtility
{
    private GroupingUtility $grouping_utility;
    private RandomCharUtility $random_char_utility;

    public function __construct(GroupingUtility $grouping_utility, RandomCharUtility $random_char_utility)
    {
        $this->grouping_utility    = $grouping_utility;
        $this->random_char_utility = $random_char_utility;
    }

    /**
     * @throws Exception
     */
    public function getRandomAntiCsrfToken(): string
    {
        $random_bytes = random_bytes(10);
        $random_hex   = bin2hex($random_bytes);
        $delimited    = $this->grouping_utility->hyphenDelimitGroupsOfFour($random_hex);
        $end_char     = $this->random_char_utility->getRandomCheckCharVersion1Lower();
        $token        = 't-' . $delimited . '-' . $end_char;

        return $token;
    }


}