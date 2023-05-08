<?php

/**
 * Footer Action
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
 * Class FooterAction
 * @package Pith\Framework\SharedInfrastructure
 */
class FooterAction extends PithAction
{
    private CopyrightYearUtility $copyright_year_utility;
    private PithInfo $pith_info;

    public function __construct(CopyrightYearUtility $copyright_year_utility, PithInfo $pith_info)
    {
        // Add Objects
        $this->copyright_year_utility = $copyright_year_utility;
        $this->pith_info = $pith_info;
    }

    public function runAction()
    {
        // Variables
        $version_text    = $this->pith_info->getVersionSlug();
        $copyright_years = $this->copyright_year_utility->getYearsByFirstYear('2008');

        // Push to Preparer
        $this->prepare->version_text    = $version_text;
        $this->prepare->copyright_years = $copyright_years;
    }
}