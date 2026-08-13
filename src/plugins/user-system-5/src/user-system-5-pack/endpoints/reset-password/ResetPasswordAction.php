<?php

/**
 * Reset Password Action
 * ---------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\UserSystem5;

use Pith\Framework\Utility\PithHeaderUtility;
use Pith\Workflow\PithAction;

/**
 * Class ResetPasswordAction
 */
class ResetPasswordAction extends PithAction
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
        $token_unsafe                = $_REQUEST['token'] ?? '';
        $new_password_unsafe         = $_REQUEST['new_password'] ?? '';
        $confirm_new_password_unsafe = $_REQUEST['confirm_new_password'] ?? '';

        $reset_info    = $this->user_service->resetPasswordWithToken($token_unsafe, $new_password_unsafe, $confirm_new_password_unsafe);
        $is_successful = ($reset_info['is_successful'] ?? 'no') === 'yes';

        // Set response code if needed
        if(!$is_successful){
            $this->header_utility->httpStatusCode207MultiStatus(); // 207 Multi-Status
        }

        // Build the response
        $response = [
            'message_status' => 'success',
            'action_status'  => $is_successful ? 'success' : 'failure',
            'data'           => [
                'reset_info' => $reset_info,
            ],
        ];

        // Push to Preparer
        $this->prepare->response = $response;
    }
}
