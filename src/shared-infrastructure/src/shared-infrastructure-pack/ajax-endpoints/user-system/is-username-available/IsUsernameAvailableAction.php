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
use Pith\Framework\SharedInfrastructure\Model\UserSystem\UserService;

/**
 * Class IsUsernameAvailableAction
 * @package Pith\Framework\SharedInfrastructure\UserSystemAjaxEndpoints
 */
class IsUsernameAvailableAction extends PithAction
{
    private UserService $user_service;

    public function __construct(UserService $user_service){
        // Set object dependencies
        $this->user_service = $user_service;
    }

    public function runAction()
    {
        $username_unsafe       = $_REQUEST['username'] ?? '';
        $is_username_available = $this->user_service->isUsernameAvailable($username_unsafe);

        // Build the response
        $response = [
            'status' => 'success',
            'data'   => [
                'is_username_available' => $is_username_available ? 'yes' : 'no',
            ],
        ];

        // Push to Preparer
        $this->prepare->response = $response;
    }
}