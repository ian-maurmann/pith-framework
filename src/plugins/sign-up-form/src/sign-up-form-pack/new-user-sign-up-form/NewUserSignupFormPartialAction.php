<?php

/**
 * New User Signup Form partial action
 * -----------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\SignUpForm;

use Pith\Workflow\PithAction;

/**
 * Class NewUserSignupFormPartialAction
 */
class NewUserSignupFormPartialAction extends PithAction
{
    public function runAction()
    {
        // Variables
        $year_19_years_ago = date('Y', strtotime('-19 year'));

        // Push to Preparer
        $this->prepare->year_19_years_ago = $year_19_years_ago;
    }
}