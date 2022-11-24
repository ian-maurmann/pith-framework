<?php

/**
 * Bottom Quote Action
 * -------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithAction;

/**
 * Class BottomQuoteAction
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample
 */
class BottomQuoteAction extends PithAction
{
    public function runAction()
    {
        // Variables
        $version_text = $this->app->info->getVersionSlug();

        // Push to Preparer
        $this->prepare->version_text = $version_text;
    }
}