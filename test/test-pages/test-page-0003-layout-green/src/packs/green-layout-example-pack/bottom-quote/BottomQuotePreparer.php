<?php

/**
 * Bottom Quote Preparer
 * ---------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithPreparer;

/**
 * Class BottomQuotePreparer
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample
 */
class BottomQuotePreparer extends PithPreparer
{
    public function runPreparer()
    {
        // Variables from Action
        $version_text = $this->prepare->version_text;
        $quote        = $this->prepare->quote;

        // Push to View
        $this->view->version_text = $this->app->escape->html($version_text);
        $this->view->quote        = $this->app->escape->html($quote);
    }
}