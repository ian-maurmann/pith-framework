<?php

/**
 * Quotes Action
 * -------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithAction;

/**
 * Class QuotesAction
 * @package Pith\Framework\SharedInfrastructure
 */
class QuotesAction extends PithAction
{
    private TestQuoteService $test_quote_service;

    public function __construct(TestQuoteService $test_quote_service)
    {
        // Add Objects
        $this->test_quote_service = $test_quote_service;
    }

    public function runAction()
    {
        // Variables
        $quote_results   = $this->test_quote_service->getQuotes();

        // Push to Preparer
        $this->prepare->quote_results = $quote_results;
    }
}