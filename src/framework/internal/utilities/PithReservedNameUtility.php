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
            'autoconfig',     // Hostname with special meaning for Thunderbird autoconfig.
            'autodiscover',   // Hostname with special meaning for MS Outlook/Exchange autoconfig.
            'broadcasthost',  // Hostname with special meaning for network broadcast hostname.
            'ftp',            // Common protocol hostname, for FTP file transfer.
            'imap',           // Common protocol hostname, for IMAP email.
            'isatap',         // Hostname with special meaning for IPv6 tunnel autodiscovery.
            'localdomain',    // (Loop-back to self hostname).
            'localhost',      // (Loop-back to self hostname).
            'mail',           // Common hostname.
            'news',           // Common hostname.
            'pop',            // Common protocol hostname, for POP email.
            'pop3',           // Common protocol hostname, for POP3 email.
            'smtp',           // Common protocol hostname, for SMTP email.
            'usenet',         // Usenet.
            'uucp',           // Common hostname.
            'webmail',        // Common hostname.
            'wpad',           // Hostname with special meaning for proxy autodiscovery.
            'www',            // Most common subdomain.
        ];

        return $reserved_names;
    }
}