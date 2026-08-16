<?php

/**
 * Request Password Reset Action
 * -----------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\UserSystem5;

use Pith\Workflow\PithAction;

/**
 * Class RequestPasswordResetAction
 */
class RequestPasswordResetAction extends PithAction
{
    private UserService $user_service;

    public function __construct(UserService $user_service){
        // Set object dependencies
        $this->user_service = $user_service;
    }

    public function runAction()
    {
        $email_address_unsafe = $_REQUEST['email_address'] ?? '';

        $reset_request_info = $this->user_service->requestPasswordReset($email_address_unsafe);
        $is_successful      = ($reset_request_info['is_successful'] ?? 'no') === 'yes';

        // Always report action success publicly (anti-enumeration)
        $response = [
            'message_status' => 'success',
            'action_status'  => 'success',
            'data'           => [
                'reset_request_info' => [
                    'is_successful' => $is_successful ? 'yes' : 'no',
                ],
            ],
        ];

        // Push to Preparer
        $this->prepare->response = $response;
    }
}
