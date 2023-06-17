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
        $username_unsafe                  = $_REQUEST['username'] ?? '';
        $email_address_unsafe             = $_REQUEST['email_address'] ?? '';
        $date_of_birth_unsafe             = $_REQUEST['date_of_birth'] ?? '';
        $new_password_unsafe              = $_REQUEST['new_password'] ?? '';
        $username_availability_info       = $this->user_service->getUsernameAvailability($username_unsafe);
        $is_available                     = $username_availability_info['is_available'] === 'yes';
        $email_address_acceptability_info = $this->user_service->spotcheckNewUserEmailAddress($email_address_unsafe);

        // Build the response
        $response = [
            'message_status' => 'success',
            'action_status'  => $is_available ? 'success' : 'failure',
            'data'           => [
                'username_availability_info'       => $username_availability_info,
                'email_address_acceptability_info' => $email_address_acceptability_info,
            ],
        ];

        // Push to Preparer
        $this->prepare->response = $response;
    }
}