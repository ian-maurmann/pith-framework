<?php

/**
 * Do-Nothing Action
 * -----------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

use Pith\Framework\PithAction;

/**
 * Class DoNothingAction
 * @package Pith\ExampleAirshipPack
 */
class DoNothingAction extends PithAction
{
    public function __construct()
    {
        // Do nothing for now.
    }

    public function runAction()
    {
        // Do nothing for now.
    }
}