<?php

/**
 * Array Utility
 * -------------
 *
 * @noinspection PhpPropertyNamingConventionInspection      - Long property names are ok.
 * @noinspection PhpMethodNamingConventionInspection        - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection      - Short variable names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection      - Ignore for readability.
 * @noinspection PhpArrayShapeAttributeCanBeAddedInspection - Ignore shape for now, add later.
 * @noinspection PhpIllegalPsrClassPathInspection           - Ignore, using PSR 4 not 0.
 * @noinspection PhpUnusedLocalVariableInspection           - Readability.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\CommandTool2;

use Exception;

/**
 * Class ArrayUtility
 */
class ArrayUtility
{
    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     * @param array $given_array
     * @param string $given_value
     * @return bool
     * @noinspection SpellCheckingInspection - Ignore "strtolower"
     */
    public function arrayHasValueInsensitive(array $given_array, string $given_value): bool
    {
        $value_lower = strtolower($given_value);
        $array_lower = array_map('strtolower', $given_array);
        return in_array($value_lower, $array_lower);
    }
}