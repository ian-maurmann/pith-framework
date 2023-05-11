<?php

/**
 * Quotes Preparer
 * ---------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithPreparer;

/**
 * Class QuotesPreparer
 * @package Pith\Framework\SharedInfrastructure
 */
class QuotesPreparer extends PithPreparer
{
    public function runPreparer()
    {
        // Variables from Action
        $version_text    = (string) $this->prepare->version_text;
        $copyright_years = (string) $this->prepare->copyright_years;
        $quote_results   = (array)  $this->prepare->quote_results;

        // Push to View
        $this->view->version_text    = $this->escape->html($version_text);
        $this->view->copyright_years = $this->escape->html($copyright_years);
        $this->view->quote_results   = $quote_results;
    }
}