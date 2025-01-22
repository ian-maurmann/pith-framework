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

use Pith\Workflow\PithPreparer;

/**
 * Class QuotesPreparer
 * @package Pith\Framework\SharedInfrastructure
 */
class LattePreparer extends PithPreparer
{
    public function runPreparer()
    {
        // Variables from Action
        $quote_results   = (array)  $this->prepare->quote_results;

        // Push to View
        $this->view->quote_results   = $quote_results;
    }
}