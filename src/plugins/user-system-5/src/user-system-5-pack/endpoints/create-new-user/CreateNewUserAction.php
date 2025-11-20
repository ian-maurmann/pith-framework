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

namespace Pith\Framework\Plugin\UserSystem4;

use Pith\Framework\Utility\PithHeaderUtility;
use Pith\Workflow\PithAction;

/**
 * Class CreateNewUserAction
 */
class CreateNewUserAction extends PithAction
{
    private UserService $user_service;
    private PithHeaderUtility $header_utility;

    public function __construct(UserService $user_service, PithHeaderUtility $header_utility){
        // Set object dependencies
        $this->user_service = $user_service;
        $this->header_utility = $header_utility;
    }

    public function runAction()
    {
        $username_unsafe             = $_REQUEST['username'] ?? '';
        $email_address_unsafe        = $_REQUEST['email_address'] ?? '';
        $new_password_unsafe         = $_REQUEST['new_password'] ?? '';
        $confirm_new_password_unsafe = $_REQUEST['confirm_new_password'] ?? '';

        $user_creation_info = $this->user_service->createUser($username_unsafe, $email_address_unsafe, $new_password_unsafe, $confirm_new_password_unsafe);
        $is_successful      = $user_creation_info['is_successful'] === 'yes';

        // Set response code if needed
        if(!$is_successful){
            $this->header_utility->httpStatusCode207MultiStatus(); // 207 Multi-Status
        }

        // Build the response
        $response = [
            'message_status' => 'success',
            'action_status'  => $is_successful ? 'success' : 'failure',
            'data'           => [
                'user_creation_info' => $user_creation_info,
            ],
        ];

        // Push to Preparer
        $this->prepare->response = $response;
    }
}