<?php
# ===================================================================
# Copyright (c) 2008-2023 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


/**
 * Pith Reserved Name Utility
 * --------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class name is ok here.
 */


declare(strict_types=1);


namespace Pith\Framework\Internal;


/**
 * Class PithReservedNameUtility
 * @package Pith\Framework\Internal
 */
class PithReservedNameUtility
{
    public function __construct()
    {
        // Do nothing for now.
    }

    /**
     *
     * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
     */
    public function getReservedNames(): array
    {
        // Looking at these resources for reference:
        //   - https://www.b-list.org/weblog/2018/feb/11/usernames/
        //   - https://ldpreload.com/blog/names-to-reserve
        //
        // I believe the way it's implemented here (but in the Python world) a correct approach:
        //   - https://github.com/ubernostrum/django-registration/blob/1d7d0f01a24b916977016c1d66823a5e4a33f2a0/registration/validators.py (License = BSD 3-Clause License)


        $reserved_names = [
            'abuse',            // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'admin',            // Certificate authority validation email - Baseline Requirements, section 3.2.2.4 item 4.
            'administrator',    // Certificate authority validation email - Baseline Requirements, section 3.2.2.4 item 4.
            'autoconfig',       // Hostname with special meaning for Thunderbird autoconfig.
            'autodiscover',     // Hostname with special meaning for MS Outlook/Exchange autoconfig.
            'broadcasthost',    // Hostname with special meaning for network broadcast hostname.
            'ftp',              // Common protocol hostname, for FTP file transfer.
            'ftp',              // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'hostmaster',       // Certificate authority validation email - Baseline Requirements, section 3.2.2.4 item 4.
            'hostmaster',       // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'imap',             // Common protocol hostname, for IMAP email.
            'info',             // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'is',               // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'isatap',           // Hostname with special meaning for IPv6 tunnel autodiscovery.
            'it',               // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'localdomain',      // (Loop-back to self hostname).
            'localhost',        // (Loop-back to self hostname).
            'mail',             // Common hostname.
            'mailer-daemon',    // Common no-reply email address for automated processes.
            'marketing',        // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'mis',              // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'news',             // Common hostname.
            'news',             // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'nobody',           // Common no-reply email address for automated processes.
            'noc',              // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'noreply',          // Common no-reply email address for automated processes.
            'no-reply',         // Common no-reply email address for automated processes.
            'pop',              // Common protocol hostname, for POP email.
            'pop3',             // Common protocol hostname, for POP3 email.
            'postmaster',       // Certificate authority validation email - Baseline Requirements, section 3.2.2.4 item 4.
            'postmaster',       // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'root',             // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'sales',            // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'security',         // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'smtp',             // Common protocol hostname, for SMTP email.
            'ssladmin',         // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'ssladministrator', // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'sslwebmaster',     // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'support',          // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'sysadmin',         // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'usenet',           // Usenet.
            'usenet',           // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'uucp',             // Common hostname.
            'uucp',             // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'webmail',          // Common hostname.
            'webmaster',        // Certificate authority validation email - Baseline Requirements, section 3.2.2.4 item 4.
            'webmaster',        // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'wpad',             // Hostname with special meaning for proxy autodiscovery.
            'www',              // Most common subdomain.
            'www',              // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
        ];

        return $reserved_names;
    }
}