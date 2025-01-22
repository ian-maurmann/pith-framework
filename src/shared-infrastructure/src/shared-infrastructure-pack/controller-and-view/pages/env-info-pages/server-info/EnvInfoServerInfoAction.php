<?php

/**
 * Env Info - Server Info Action
 * -----------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages;

use Pith\Workflow\PithAction;

/**
 * Class EnvInfoServerInfoAction
 * @package Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages
 */
class EnvInfoServerInfoAction extends PithAction
{
    public function runAction()
    {
        // Push to Preparer
        $this->prepare->server_information = $_SERVER;
    }
}