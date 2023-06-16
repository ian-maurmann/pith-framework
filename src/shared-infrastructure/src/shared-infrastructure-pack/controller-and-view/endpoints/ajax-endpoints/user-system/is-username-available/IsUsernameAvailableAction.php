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
        $username_unsafe            = $_REQUEST['username'] ?? '';
        $username_availability_info = $this->user_service->getUsernameAvailability($username_unsafe);
        $is_available               = $username_availability_info['is_available'] === 'yes';

        // Build the response
        $response = [
            'message_status' => 'success',
            'action_status'  => $is_available ? 'success' : 'failure',
            'data'           => $username_availability_info,
        ];

        // Push to Preparer
        $this->prepare->response = $response;
    }
}