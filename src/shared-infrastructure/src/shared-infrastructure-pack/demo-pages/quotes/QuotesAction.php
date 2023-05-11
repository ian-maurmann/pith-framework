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

use IKM\CopyrightYearUtility\CopyrightYearUtility;
use Pith\Framework\PithAction;
use Pith\Framework\PithInfo;

/**
 * Class QuotesAction
 * @package Pith\Framework\SharedInfrastructure
 */
class QuotesAction extends PithAction
{
    private CopyrightYearUtility $copyright_year_utility;
    private PithInfo $pith_info;
    private TestQuoteService $test_quote_service;

    public function __construct(CopyrightYearUtility $copyright_year_utility, PithInfo $pith_info, TestQuoteService $test_quote_service)
    {
        // Add Objects
        $this->copyright_year_utility = $copyright_year_utility;
        $this->pith_info              = $pith_info;
        $this->test_quote_service     = $test_quote_service;
    }

    public function runAction()
    {
        // Variables
        $version_text    = $this->pith_info->getVersionSlug();
        $copyright_years = $this->copyright_year_utility->getYearsByFirstYear('2008');
        $quote_results   = $this->test_quote_service->getQuotes();

        // Push to Preparer
        $this->prepare->version_text    = $version_text;
        $this->prepare->copyright_years = $copyright_years;
        $this->prepare->quote_results   = $quote_results;
    }
}