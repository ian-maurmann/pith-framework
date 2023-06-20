<?php

/**
 * Create New User Action
 * ----------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Endpoints\UserSystemAjaxEndpoints;

use Pith\Framework\PithAction;
use Pith\Framework\SharedInfrastructure\Model\UserSystem\UserService;

/**
 * Class CreateNewUserAction
 * @package Pith\Framework\SharedInfrastructure\Endpoints\UserSystemAjaxEndpoints
 */
class CreateNewUserAction extends PithAction
{
    private UserService $user_service;

    public function __construct(UserService $user_service){
        // Set object dependencies
        $this->user_service = $user_service;
    }

    public function runAction()
    {
        $username_unsafe             = $_REQUEST['username'] ?? '';
        $email_address_unsafe        = $_REQUEST['email_address'] ?? '';
        $date_of_birth_unsafe        = $_REQUEST['date_of_birth_yyyy_mm_dd'] ?? '';
        $new_password_unsafe         = $_REQUEST['new_password'] ?? '';
        $confirm_new_password_unsafe = $_REQUEST['confirm_new_password'] ?? '';

        $user_creation_acceptability_info = $this->user_service->spotcheckNewUserInfo($username_unsafe, $email_address_unsafe, $date_of_birth_unsafe, $new_password_unsafe, $confirm_new_password_unsafe);
        $is_acceptable                    = $user_creation_acceptability_info['is_acceptable'] === 'yes';

        // Build the response
        $response = [
            'message_status' => 'success',
            'action_status'  => $is_acceptable ? 'success' : 'failure',
            'data'           => [
                'user_creation_acceptability_info' => $user_creation_acceptability_info,
            ],
        ];

        // Push to Preparer
        $this->prepare->response = $response;
    }
}