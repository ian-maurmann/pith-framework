<?php

/**
 * Env Info - Sidebar Partial Action
 * ---------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages;

use Pith\Framework\PithAction;

/**
 * Class EnvInfoSidebarPartialAction
 * @package Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages
 */
class EnvInfoSidebarPartialAction extends PithAction
{
    public function runAction()
    {
        // Push to Preparer
        $this->prepare->PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH = PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH;
    }
}