<?php

/**
 * Do-Nothing Preparer
 * -------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

use Pith\Framework\PithPreparer;

/**
 * Class DoNothingPreparer
 * @package Pith\ExampleAirshipPack
 */
class DoNothingPreparer extends PithPreparer
{
    public function __construct()
    {
        // Do nothing for now.
    }

    public function runPreparer()
    {
        // Do nothing for now.
    }
}