<?php

/**
 * Send Test Email endpoint action
 * -------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection    - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection     - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection    - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection       - Long class name is ok.
 * PhpUnnecessaryLeadingBackslashInUseStatementInspection - Use \Exception.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use \Exception;
use Pith\Framework\PithEmailBuilder;
use Pith\Framework\PithException;
use Pith\Workflow\PithAction;

/**
 * Class SendTestEmailEndpointAction
 */
class SendTestEmailEndpointAction extends PithAction
{
    private PithEmailBuilder $email_builder;

    public function __construct(PithEmailBuilder $email_builder){
        // Set object dependencies
        $this->email_builder = $email_builder;
    }

    public function runAction()
    {
        $did_send = false;

        // Build the response
        $response = [
            'message_status' => 'success',
            'action_status'  => $did_send ? 'success' : 'failure',
        ];

        // Send the email
        try {
            // Build the email
            $this->email_builder->reset();
            $this->email_builder->setFrom('from@example.com', 'Test Sender');
            $this->email_builder->addTo('recipient@example.com');
            $this->email_builder->setSubject('Test Email');
            $this->email_builder->setBody('This is a test email.');
            $this->email_builder->setIsHtml(false);

            // Send the email
            $this->email_builder->send();
        } catch (PithException | Exception $exception) {
            // Handle the exception
        }

        // Push to Preparer
        $this->prepare->response = $response;
    }
}