<?php
# ===================================================================
# Copyright (c) 2008-2024 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

/**
 * Pith Adapter for PHPMailer
 * --------------------------
 *
 * For info on PHPMailer, see Git repo at https://github.com/PHPMailer/PHPMailer
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Short method names are ok.
 * @noinspection PhpUnused                             - Will be used by workflow elements.
 * @noinspection PhpTooManyParametersInspection        - Methods with a large number of parameters are ok here.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */

declare(strict_types=1);

namespace Pith\PhpmailerEmailAdapter;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Pith\Framework\PithException;

/**
 * Class PithPhpmailerEmailAdapter
 * @package Pith\LatteViewAdapter
 */
class PithPhpmailerEmailAdapter
{
    private string $from_address;
    private string $from_name;
    private array  $to_list;
    private array  $reply_to_list;
    private array  $cc_list;
    private array  $bcc_list;
    private array  $attachment_list;
    private bool   $is_html;
    private string $subject;
    private string $body;
    private string $alt_body;

    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->from_address    = '';
        $this->from_name       = '';
        $this->to_list         = [];
        $this->reply_to_list   = [];
        $this->cc_list         = [];
        $this->bcc_list        = [];
        $this->attachment_list = [];
        $this->is_html         = false;
        $this->subject         = '';
        $this->body            = '';
        $this->alt_body        = '';
    }

    /**
     * @param string $email_address
     * @param string $name
     */
    public function setFrom(string $email_address, string $name = '')
    {
        $this->from_address = $email_address;
        $this->from_name = $name;
    }

    /**
     * @param string $email_address
     * @param string $name
     */
    public function addTo(string $email_address, string $name = '')
    {
        // Build new TO list item
        $listing = [
            'email_address' => $email_address,
            'name'          => $name,
        ];

        // Add to TO list
        $this->to_list[] = $listing;
    }

    /**
     * @param string $email_address
     * @param string $name
     */
    public function addReplyTo(string $email_address, string $name = '')
    {
        // Build new REPLY TO list item
        $listing = [
            'email_address' => $email_address,
            'name'          => $name,
        ];

        // Add to REPLY TO list
        $this->reply_to_list[] = $listing;
    }

    /**
     * @param string $email_address
     * @param string $name
     */
    public function addCC(string $email_address, string $name = '')
    {
        // Build new CC list item
        $listing = [
            'email_address' => $email_address,
            'name'          => $name,
        ];

        // Add to CC list
        $this->cc_list[] = $listing;
    }

    /**
     * @param string $email_address
     * @param string $name
     */
    public function addBCC(string $email_address, string $name = '')
    {
        // Build new BCC list item
        $listing = [
            'email_address' => $email_address,
            'name'          => $name,
        ];

        // Add to BCC list
        $this->bcc_list[] = $listing;
    }

    /**
     * @param string $attachment_file_path
     * @param string $name
     */
    public function addAttachment(string $attachment_file_path, string $name = '')
    {
        // Build new BCC list item
        $listing = [
            'attachment_file_path' => $attachment_file_path,
            'name'                 => $name,
        ];

        // Add to BCC list
        $this->attachment_list[] = $listing;
    }

    /**
     * @param bool $is_html
     */
    public function setIsHtml(bool $is_html)
    {
        $this->is_html = $is_html;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param string $message_body
     */
    public function setBody(string $message_body)
    {
        $this->body = $message_body;
    }

    /**
     * @param string $plain_text
     */
    public function setAltBody(string $plain_text)
    {
        $this->alt_body = $plain_text;
    }

    /**
     * @param string $from_address
     * @param string $from_name
     * @param array $to_list
     * @param array $reply_to_list
     * @param array $cc_list
     * @param array $bcc_list
     * @param array $attachment_list
     * @param bool $is_html
     * @param string $subject
     * @param string $body
     * @param string $alt_body
     */
    public function prepare(string $from_address, string $from_name, array $to_list, array $reply_to_list, array $cc_list, array $bcc_list, array $attachment_list, bool $is_html, string $subject, string $body, string $alt_body)
    {
        $this->from_address    = $from_address;
        $this->from_name       = $from_name;
        $this->to_list         = $to_list;
        $this->reply_to_list   = $reply_to_list;
        $this->cc_list         = $cc_list;
        $this->bcc_list        = $bcc_list;
        $this->attachment_list = $attachment_list;
        $this->is_html         = $is_html;
        $this->subject         = $subject;
        $this->body            = $body;
        $this->alt_body        = $alt_body;
    }

    /**
     * @throws PithException
     */
    public function send(): bool
    {
        // Default to false
        $did_send = false;

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Enable verbose debug output
            if(PITH_EMAIL_ENABLE_VERBOSE_DEBUGGING){
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            }

            //Server settings
            $mail->isSMTP();                                           //Send using SMTP
            $mail->Host       = PITH_EMAIL_SMTP_HOST;                  //Set the SMTP server to send through
            $mail->SMTPAuth   = PITH_EMAIL_ENABLE_SMTP_AUTHENTICATION; //Enable SMTP authentication
            $mail->Username   = PITH_EMAIL_SMTP_USERNAME;              //SMTP username
            $mail->Password   = PITH_EMAIL_SMTP_PASSWORD;              //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           //Enable implicit TLS encryption

            //Enable implicit TLS encryption
            if(PITH_EMAIL_ENABLE_IMPLICIT_TLS){
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            }

            // Port
            $mail->Port = PITH_EMAIL_SMTP_PORT; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Set email message FROM Address
            $mail->setFrom($this->from_address, $this->from_name);

            // Add email message TO Recipients
            $to_list = $this->to_list;
            foreach ($to_list as $to_listing) {
                $to_email_address = $to_listing['email_address'];
                $to_name          = $to_listing['name'];
                $has_to_name      = !empty($to_name);

                if($has_to_name){
                    $mail->addAddress($to_email_address, $to_name); //Add recipient
                } else {
                    $mail->addAddress($to_email_address); //Add recipient
                }
            }

            // Add email message REPLY TO Addresses
            $reply_to_list = $this->reply_to_list;
            foreach ($reply_to_list as $reply_to_listing) {
                $reply_to_email_address = $reply_to_listing['email_address'];
                $reply_to_name          = $reply_to_listing['name'];
                $has_reply_to_name      = !empty($reply_to_name);

                if($has_reply_to_name){
                    $mail->addReplyTo($reply_to_email_address, $reply_to_name); // Add reply-to address
                } else {
                    $mail->addReplyTo($reply_to_email_address); // Add reply-to address
                }
            }

            // Add email message CC Recipients
            $cc_list = $this->cc_list;
            foreach ($cc_list as $cc_listing) {
                $cc_email_address = $cc_listing['email_address'];
                $cc_name          = $cc_listing['name'];
                $has_cc_name      = !empty($cc_name);

                if($has_cc_name){
                    $mail->addCC($cc_email_address, $cc_name); //Add CC recipient
                } else {
                    $mail->addCC($cc_email_address); //Add CC recipient
                }
            }

            // Add email message BCC Recipients
            $bcc_list = $this->bcc_list;
            foreach ($bcc_list as $bcc_listing) {
                $bcc_email_address = $bcc_listing['email_address'];
                $bcc_name          = $bcc_listing['name'];
                $has_bcc_name      = !empty($bcc_name);

                if($has_bcc_name){
                    $mail->addBCC($bcc_email_address, $bcc_name); //Add BCC recipient
                } else {
                    $mail->addBCC($bcc_email_address); //Add BCC recipient
                }
            }

            // Add Attachments
            $attachment_list = $this->attachment_list;
            foreach ($attachment_list as $attachment_listing) {
                $attachment_file_path = $attachment_listing['attachment_file_path'];
                $attachment_name      = $attachment_listing['name'];
                $has_attachment_name  = !empty($attachment_name);

                if($has_attachment_name){
                    $mail->addAttachment($attachment_file_path, $attachment_name); //Add attachment
                } else {
                    $mail->addAttachment($attachment_file_path); //Add attachment
                }
            }

            //Content
            $mail->isHTML($this->is_html);
            $mail->Subject = $this->subject;
            $mail->Body    = $this->body;
            $mail->AltBody = $this->alt_body;

            $did_send = $mail->send();
        } catch (Exception $exception) {
            $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

            throw new PithException(
                'Pith Framework Exception 8004: The Email Adapter for PHPMailer was unable to send the email message. ErrorInfo from PHPMailer: ' . $exception->getMessage(),
                8004,
                $exception
            );
        }

        return $did_send;
    }
}