<?php

/**
 * Is Username Available Action
 * ----------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\UserSystemAjaxEndpoints;

use Pith\Framework\PithAction;

/**
 * Class IsUsernameAvailableAction
 * @package Pith\Framework\SharedInfrastructure\UserSystemAjaxEndpoints
 */
class IsUsernameAvailableAction extends PithAction
{
    public function runAction()
    {
        $is_username_available = false;

        $response = [
            'status'                => 'success',
            'data'                  => [
                'is_username_available' => $is_username_available ? 'yes' : 'no',
            ],
        ];

        // Push to Preparer
        $this->prepare->response = $response;
    }
}