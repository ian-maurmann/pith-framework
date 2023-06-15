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
        $username_availability = $this->user_service->getUsernameAvailability($username_unsafe);
        $is_username_available = (bool) $username_availability['is_available'];
        $unavailability_reason = (string) $username_availability['reason'];
        $normalization_matches = (array) $username_availability['normalization_info'];
        $normalized_name       = (string) $username_availability['normalized_name'];

        // Build the response
        $response = [
            'message_status' => 'success',
            'action_status'  => $is_username_available ? 'success' : 'failure',
            'data'           => [
                'normalized_name'       => $normalized_name,
                'is_username_available' => $is_username_available ? 'yes' : 'no',
                'reason'                => $unavailability_reason,
                'normalization_matches' => $normalization_matches,
            ],
        ];

        // Push to Preparer
        $this->prepare->response = $response;
    }
}