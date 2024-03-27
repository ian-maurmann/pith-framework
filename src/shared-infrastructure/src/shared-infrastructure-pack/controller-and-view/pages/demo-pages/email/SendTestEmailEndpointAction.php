<?php

/**
 * Send Test Email endpoint action
 * -------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithAction;

/**
 * Class SendTestEmailEndpointAction
 * @package Pith\Framework\SharedInfrastructure\Endpoints\UserSystemAjaxEndpoints
 */
class SendTestEmailEndpointAction extends PithAction
{
    //private UserService $user_service;

    public function __construct(){
        // Set object dependencies
        //$this->user_service = $user_service;
    }

    public function runAction()
    {
        $did_send = false;

        // Build the response
        $response = [
            'message_status' => 'success',
            'action_status'  => $did_send ? 'success' : 'failure',
        ];

        // Push to Preparer
        $this->prepare->response = $response;
    }
}