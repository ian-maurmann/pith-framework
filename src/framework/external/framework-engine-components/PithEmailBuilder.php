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
 * Pith Email Builder
 * ------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok here.
 */


declare(strict_types=1);

namespace Pith\Framework;


/**
 * Class PithEmailBuilder
 * @package Pith\Framework
 */
class PithEmailBuilder
{
    // Mostly modeled to work with PHPMailer

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

    public function send()
    {

    }
}