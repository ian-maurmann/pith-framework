<?php
# ===================================================================
# Copyright (c) 2008-2025 Ian K Maurmann. The Pith Framework is
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
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok here.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 * @noinspection PhpPureAttributeCanBeAddedInspection  - Not making as pure for now, maybe later.
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
     * @param $given_name
     * @return bool
     */
    public function isReserved($given_name): bool
    {
        $is_inside_reserved_name_list        = $this->isInsideReservedNameList($given_name);
        $is_reserved_when_followed_by_number = $this->isReservedWhenFollowedByNumber($given_name);
        $is_reserved                         = $is_inside_reserved_name_list || $is_reserved_when_followed_by_number;

        return $is_reserved;
    }

    /**
     * @param $given_name
     * @return bool
     */
    public function isInsideReservedNameList($given_name): bool
    {
        $is_inside_reserved_name_list = false;
        $reserved_names = $this->getReservedNames();

        if(in_array($given_name, $reserved_names)){
            $is_inside_reserved_name_list = true;
        }

        return $is_inside_reserved_name_list;
    }


    /**
     * @param  $given_name
     * @return bool
     */
    public function isReservedWhenFollowedByNumber($given_name): bool
    {
        // Default to false
        $is_reserved_followed_by_number = false;

        // See if the given name is a name that cannot be followed by a number
        $array_of_names_reserved_with_number = $this->getReservedStartingStringsWhenFollowedByNumber();
        foreach ($array_of_names_reserved_with_number as $name_reserved_with_number){
            $starts_with_reserved_name = str_starts_with($given_name, $name_reserved_with_number);
            if($starts_with_reserved_name){
                $second_half_of_given_name = substr($given_name, strlen($name_reserved_with_number));

                if(str_starts_with($second_half_of_given_name, '-')){
                    $second_half_of_given_name = substr($second_half_of_given_name, 1);
                }

                if(str_starts_with($second_half_of_given_name, '_')){
                    $second_half_of_given_name = substr($second_half_of_given_name, 1);
                }

                $is_reserved_followed_by_number = is_numeric($second_half_of_given_name);
            }
        }

        // Return true if the given name is a reserved name followed by number
        return $is_reserved_followed_by_number;
    }



    /**
     * @return string[]
     */
    public function getReservedNames(): array
    {
        // Looking at these resources for reference:
        //   - https://www.b-list.org/weblog/2018/feb/11/usernames/
        //   - https://ldpreload.com/blog/names-to-reserve
        //   - https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
        //
        // I believe the way it's implemented in Django-Registration (but in the Python world) is the correct approach:
        //   - https://github.com/ubernostrum/django-registration/blob/1d7d0f01a24b916977016c1d66823a5e4a33f2a0/registration/validators.py (License = BSD 3-Clause License)



        $reserved_names = [
            '.htaccess',              // Sensitive filename.
            '.htpasswd',              // Sensitive filename.
            '.well-known',            // Sensitive filename.
            'a',                      // (Names that I think might cause issues).
            'about',                  // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'abuse',                  // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'account',                // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'accounts',               // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'admin',                  // Certificate authority validation email - Baseline Requirements, section 3.2.2.4 item 4.
            'administrator',          // Certificate authority validation email - Baseline Requirements, section 3.2.2.4 item 4.
            'app',                    // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'autoconfig',             // Hostname with special meaning for Thunderbird autoconfig.
            'autodiscover',           // Hostname with special meaning for MS Outlook/Exchange autoconfig.
            'blog',                   // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'branch',                 // (Names that I think might cause issues).
            'broadcast',              // (Names that I think might cause issues).
            'broadcasthost',          // Hostname with special meaning for network broadcast hostname.
            'buy',                    // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'c',                      // (Names that I think might cause issues).
            'clients',                // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'clientaccesspolicy.xml', // Sensitive filename, Silverlight cross-domain policy file.
            'community',              // Names that are reserved in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/ - "commonly-used email addresses"
            'config',                 // (Names that I think might cause issues).
            'contact',                // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'contactus',              // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'contact-us',             // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'copyright',              // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'crossdomain.xml',        // Sensitive filename, Flash cross-domain policy file.
            'css',                    // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'dashboard',              // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'dev',                    // (Names that I think might cause issues).
            'develop',                // (Names that I think might cause issues).
            'developer',              // (Names that I think might cause issues).
            'developers',             // (Names that I think might cause issues).
            'development',            // (Names that I think might cause issues).
            'developmentteam',        // (Names that I think might cause issues).
            'development-team',       // (Names that I think might cause issues).
            'devs',                   // (Names that I think might cause issues).
            'devteam',                // (Names that I think might cause issues).
            'dev-team',               // (Names that I think might cause issues).
            'doc',                    // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'docs',                   // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'domainadmin',            // Names that are reserved in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/ - "admin-ish usernames"
            'domainadministrator',    // Names that are reserved in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/ - "admin-ish usernames"
            'download',               // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'downloads',              // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'email',                  // (Names that I think might cause issues).
            'emails',                 // (Names that I think might cause issues).
            'enquiry',                // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'enquiries',              // (Names that I think might cause issues).
            'errors',                 // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'events',                 // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'example',                // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'faq',                    // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'faqs',                   // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'favicon.ico',            // Browser-necessary filename.
            'feature',                // (Names that I think might cause issues).
            'features',               // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'ftp',                    // Common protocol hostname, for FTP file transfer.
            'ftp',                    // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'ftps',                   // (Names that I think might cause issues).
            'guest',                  // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'guests',                 // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'help',                   // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'helper',                 // (Names that I think might cause issues).
            'host',                   // (Names that I think might cause issues).
            'hosts',                  // (Names that I think might cause issues).
            'hostmaster',             // Certificate authority validation email - Baseline Requirements, section 3.2.2.4 item 4.
            'hostmaster',             // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'http',                   // (Names that I think might cause issues).
            'https',                  // (Names that I think might cause issues).
            'humans.txt',             // Reserved filename, ( https://humanstxt.org/Standard.html ).
            'image',                  // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'images',                 // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'imap',                   // Common protocol hostname, for IMAP email.
            'img',                    // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'indev',                  // (Names that I think might cause issues).
            'info',                   // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'inquiry',                // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'is',                     // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'isatap',                 // Hostname with special meaning for IPv6 tunnel autodiscovery.
            'it',                     // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'js',                     // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'keybase.txt',            // Sensitive filename, Keybase ownership-verification URL.
            'license',                // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'local',                  // (Names that I think might cause issues).
            'localdomain',            // (Loop-back to self hostname).
            'localhost',              // (Loop-back to self hostname).
            'login',                  // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'logout',                 // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'mail',                   // Common hostname.
            'mailer   ',              // (Names that I think might cause issues).
            'mailerdaemon',           // Names that are reserved in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/ - "commonly-used email addresses"
            'mailer-daemon',          // Common no-reply email address for automated processes.
            'main',                   // (Names that I think might cause issues).
            'master',                 // (Names that I think might cause issues).
            'marketing',              // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'me',                     // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'media',                  // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'mis',                    // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'mod',                    // (Names that I think might cause issues).
            'moderator',              // (Names that I think might cause issues).
            'mx',                     // (Names that I think might cause issues).
            'myaccount',              // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'myself',                 // (Names that I think might cause issues).
            'new',                    // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'news',                   // Common hostname.
            'news',                   // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'nobody',                 // Common no-reply email address for automated processes.
            'noc',                    // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'noreply',                // Common no-reply email address for automated processes.
            'no-reply',               // Common no-reply email address for automated processes.
            'ns',                     // DNS Nameserver Subdomain.
            'ns0',                    // DNS Nameserver Subdomain.
            'ns1',                    // DNS Nameserver Subdomain.
            'ns2',                    // DNS Nameserver Subdomain.
            'ns3',                    // DNS Nameserver Subdomain.
            'ns4',                    // DNS Nameserver Subdomain.
            'ns5',                    // DNS Nameserver Subdomain.
            'ns6',                    // DNS Nameserver Subdomain.
            'ns7',                    // DNS Nameserver Subdomain.
            'ns8',                    // DNS Nameserver Subdomain.
            'ns9',                    // DNS Nameserver Subdomain.
            'ns10',                   // DNS Nameserver Subdomain.
            'ns11',                   // DNS Nameserver Subdomain.
            'ns12',                   // DNS Nameserver Subdomain.
            'owner',                  // Names that are reserved in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/ - "admin-ish usernames"
            'password',               // (Names that I think might cause issues).
            'passwords',              // (Names that I think might cause issues).
            'passwordreset',          // (Names that I think might cause issues).
            'password-reset',         // (Names that I think might cause issues).
            'payment',                // (Names that I think might cause issues).
            'payments',               // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'pith',                   // (Framework meta)
            'pith-framework',         // (Framework meta)
            'pith_user',              // (Framework meta)
            'plans',                  // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'policy',                 // (Names that I think might cause issues).
            'pop',                    // Common protocol hostname, for POP email.
            'pop3',                   // Common protocol hostname, for POP3 email.
            'portfolio',              // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'postmaster',             // Certificate authority validation email - Baseline Requirements, section 3.2.2.4 item 4.
            'postmaster',             // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'preferences',            // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'pricing',                // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'privacy',                // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'prod',                   // (Names that I think might cause issues).
            'production',             // (Names that I think might cause issues).
            'profile',                // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'register',               // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'reset',                  // (Names that I think might cause issues).
            'robots.txt',             // Sensitive filename.
            'root',                   // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            's',                      // (Names that I think might cause issues).
            'sales',                  // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'secure',                 // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'security',               // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'self',                   // (Names that I think might cause issues).
            'serve',                  // (Names that I think might cause issues).
            'server',                 // (Names that I think might cause issues).
            'service',                // (Names that I think might cause issues).
            'settings',               // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'signin',                 // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'sign-in',                // (Names that I think might cause issues).
            'signout',                // (Names that I think might cause issues).
            'sign-out',               // (Names that I think might cause issues).
            'signup',                 // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'sign-up',                // (Names that I think might cause issues).
            'smtp',                   // Common protocol hostname, for SMTP email.
            'src',                    // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'ssl',                    // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'ssladmin',               // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'ssladministrator',       // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'sslwebmaster',           // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'stage',                  // (Names that I think might cause issues).
            'staging',                // (Names that I think might cause issues).
            'status',                 // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'subscribe',              // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'support',                // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'sys',                    // Names that are reserved in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'sysadmin',               // Certificate authority validation email - 2009 - ( https://bugzilla.mozilla.org/show_bug.cgi?id=477783#c19 ).
            'system',                 // Names that are reserved in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'terms',                  // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'tos',                    // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'trunk',                  // (Names that I think might cause issues).
            'tutorial',               // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'tutorials',              // Commonly-used top paths in the list at https://zimbatm.github.io/hostnames-and-usernames-to-reserve/
            'usenet',                 // Usenet hostname.
            'usenet',                 // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'user',                   // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'users',                  // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'uucp',                   // Common hostname.
            'uucp',                   // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'vlog',                   // (Names that I think might cause issues).
            'webmail',                // Common hostname.
            'weblog',                 // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'webmaster',              // Certificate authority validation email - Baseline Requirements, section 3.2.2.4 item 4.
            'webmaster',              // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'work',                   // (Other names that I see that Django-Registration reserves, which could be problems depending on URL/subdomain structure).
            'wpad',                   // Hostname with special meaning for proxy autodiscovery.
            'w',                      // (Names that I think might cause issues).
            'ww',                     // www alternate.
            'www',                    // World Wide Web subdomain.
            'www',                    // RFC-2142: MAILBOX NAMES FOR COMMON SERVICES, ROLES AND FUNCTIONS.
            'www0',                   // www alternate.
            'www1',                   // www alternate.
            'www2',                   // www alternate.
            'www3',                   // www alternate.
            'www4',                   // www alternate.
            'www5',                   // www alternate.
            'www6',                   // www alternate.
            'www7',                   // www alternate.
            'www8',                   // www alternate.
            'www9',                   // www alternate.
            'www10',                  // www alternate.
            'www11',                  // www alternate.
            'www12',                  // www alternate.
            'www13',                  // www alternate.
            'www14',                  // www alternate.
            'www15',                  // www alternate.
            'www16',                  // www alternate.
            'www17',                  // www alternate.
            'www18',                  // www alternate.
            'www19',                  // www alternate.
            'www20',                  // www alternate.
            'www21',                  // www alternate.
            'www22',                  // www alternate.
            'www23',                  // www alternate.
            'x',                      // (Names that I think might cause issues).
            'xyz',                    // www alternate.
            'xyz0',                   // www alternate.
            'xyz1',                   // www alternate.
            'xyz2',                   // www alternate.
            'xyz3',                   // www alternate.
            'xyz4',                   // www alternate.
            'xyz5',                   // www alternate.
            'xyz6',                   // www alternate.
            'xyz7',                   // www alternate.
            'xyz8',                   // www alternate.
            'xyz9',                   // www alternate.
        ];

        return $reserved_names;
    }


    /**
     * @return string[]
     */
    public function getReservedStartingStringsWhenFollowedByNumber(): array
    {
        // TODO - Reserve when followed by a number.
        // TODO - Also reserve when followed by hyphen and then a number.

        $reserved_starts = [
            'abuse',
            'admin',
            'administrator',
            'ftp',
            'dev',
            'develop',
            'development',
            'http',
            'imap',
            'indev',
            'mail',
            'mailer-daemon',
            'marketing',
            'mod',
            'moderator',
            'noreply',
            'no-reply',
            'ns',
            's',
            'stage',
            'staging',
            'support',
            'smtp',
            'ssl',
            'pop',
            'prod',
            'production',
            'user',
            'w',
            'ww',
            'www',
            'wwww',
            'wwwww',
            'xyz',
        ];

        return $reserved_starts;
    }




}