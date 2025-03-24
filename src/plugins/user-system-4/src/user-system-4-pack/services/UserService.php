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
 * User Service
 * ------------
 *
 * @noinspection PhpPropertyNamingConventionInspection      - Long property names are ok.
 * @noinspection PhpMethodNamingConventionInspection        - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection      - Short variable names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection      - Ignore for readability.
 * @noinspection PhpArrayShapeAttributeCanBeAddedInspection - Ignore shape for now, add later.
 * @noinspection PhpIllegalPsrClassPathInspection           - Ignore, using PSR 4 not 0.
 * @noinspection PhpUnusedLocalVariableInspection           - Readability.
 */


declare(strict_types=1);


namespace Pith\Framework\Plugin\UserSystem4;

use Exception;
use Pith\Framework\PithDatabaseWrapper;
use Pith\Framework\PithException;
use Pith\Framework\Utility\RandomCharUtility;
use Ulid\Ulid;

/**
 * Class UserService
 */
class UserService
{
    // private AccessLevelGateway       $access_level_gateway;
    private PithDatabaseWrapper      $database;
    // private LoginCredentialGateway   $login_credential_gateway;
    // private PasswordGateway          $password_gateway;
    private PasswordUtility          $password_utility;
    private RandomCharUtility        $random_char_utility;
    // private UserAccountInfoGateway   $user_account_info_gateway;
    // private UserCreationQueueGateway $user_creation_queue_gateway;
    // private UserEmailAddressGateway  $user_email_address_gateway;
    private UserGateway              $user_gateway;
    // private UsernameGateway          $username_gateway;
    private UsernameNormalizer       $username_normalizer;

    public function __construct(PithDatabaseWrapper $database, PasswordUtility $password_utility, RandomCharUtility $random_char_utility, UserGateway $user_gateway, UsernameNormalizer $username_normalizer)
    {
        // Set object dependencies:
     // $this->access_level_gateway        = $access_level_gateway;
        $this->database                    = $database;
     // $this->login_credential_gateway    = $login_credential_gateway;
     // $this->password_gateway            = $password_gateway;
        $this->password_utility            = $password_utility;
        $this->random_char_utility         = $random_char_utility;
     // $this->user_account_info_gateway   = $user_account_info_gateway;
     // $this->user_creation_queue_gateway = $user_creation_queue_gateway;
     // $this->user_email_address_gateway  = $user_email_address_gateway;
        $this->user_gateway                = $user_gateway;
     // $this->username_gateway            = $username_gateway;
        $this->username_normalizer         = $username_normalizer;
    }

    /**
     * @param $given_name
     * @return array
     */
    public function getUsernameAvailability($given_name): array
    {
        $is_available = false;
        $name_info    = $this->username_normalizer->getNameInfo($given_name);
        $is_allowed   = $name_info['is_allowed'] === 'yes';
        $fail_reason  = $name_info['fail_reason'];

        if($is_allowed){
            $name             = $name_info['name_normalized'];
            $name_lower       = $name_info['name_normalized_lower'];
            try{
                $name_results     = $this->user_gateway->findUsernameResults($name, $name_lower);
                $has_name_results = count($name_results) > 0;
                $fail_reason      = $has_name_results ? 'username-unavailable' : $fail_reason;
                $is_available     = !$has_name_results;
            } catch (PithException $pith_exception){
                $is_available = false;
                $fail_reason  = 'database-query-exception';
            }
        }

        // Build return
        $r = [
            'is_too_long'           => $name_info['is_too_long'],
            'name_normalized'       => $name_info['name_normalized'],
            'name_normalized_lower' => $name_info['name_normalized_lower'],
            'is_reserved'           => $name_info['is_reserved'],
            'problem_char_index'    => $name_info['problem_char_index'],
            'is_allowed'            => $name_info['is_allowed'],
            'is_available'          => $is_available ? 'yes' : 'no',
            'fail_reason'           => $fail_reason,
        ];

        return $r;
    }

    /**
     * @param string $given_email_address
     * @return array
     */
    public function spotcheckNewUserEmailAddress(string $given_email_address): array
    {
        $is_ok       = true;
        $fail_reason = '';

        // Continue on success, Stop on failure
        try{
            if(empty($given_email_address)){
                throw new Exception('email-address-is-empty');
            }

            $email_address_char_length = mb_strlen($given_email_address);
            $at_sign_position          = mb_strpos($given_email_address, '@');

            $has_at_sign = $at_sign_position !== false;
            if(!$has_at_sign){
                throw new Exception('email-address-does-not-have-at-sign');
            }

            $is_at_sign_at_start = $at_sign_position === 0;
            if($is_at_sign_at_start){
                throw new Exception('email-address-does-not-have-name');
            }

            $is_at_sign_too_late = !(($email_address_char_length - 3) > $at_sign_position);
            if($is_at_sign_too_late){
                throw new Exception('email-address-does-not-have-domain');
            }

            $domain             = mb_substr($given_email_address,$at_sign_position + 1);
            $domain_char_length = mb_strlen($domain);
            $dot_position       = mb_strpos($domain, '.');

            $has_dot = $dot_position !== false;
            if(!$has_dot){
                throw new Exception('email-address-domain-does-not-have-dot');
            }

            $is_dot_at_start = $dot_position === 0;
            if($is_dot_at_start){
                throw new Exception('email-address-dot-is-at-start-of-domain');
            }

            $is_at_first_dot_at_end = !(($domain_char_length - 1) > $dot_position);
            if($is_at_first_dot_at_end){
                throw new Exception('email-address-first-dot-in-domain-is-at-the-end');
            }
        }catch (Exception $e) {
            $is_ok       = false;
            $fail_reason = $e->getMessage();
        }

        // Build the response
        $response = [
            // 'email_address' => $given_email_address,
            'is_allowed'    => $is_ok ? 'yes' : 'no',
            'fail_reason'   => $fail_reason,
        ];

        return $response;
    }



    /**
     * @param string $given_date_of_birth
     * @return array
     * @noinspection PhpUnusedLocalVariableInspection - Ignore for readability.
     */
    public function spotcheckNewUserDateOfBirth(string $given_date_of_birth): array
    {
        $is_ok             = false;
        $fail_reason       = '';
        $year_yyyy         = '';
        $month_mm          = '';
        $day_dd            = '';
        $current_year_yyyy = date('Y');
        $current_year_int  = (int) $current_year_yyyy;
        $year_19_ago_int   = $current_year_int - 19;
        $yyyy_19_years_ago = (string) $year_19_ago_int;

        // Continue on success, Stop on failure
        try{
            // Check if empty
            if(empty($given_date_of_birth)){
                throw new Exception('date-of-birth-is-empty');
            }

            // Check if long enough
            $dob_string_length = strlen($given_date_of_birth);
            $is_dob_string_10_chars = $dob_string_length === 10;
            if(!$is_dob_string_10_chars){
                throw new Exception('date-of-birth-is-not-the-correct-length');
            }

            // Get year
            $year_yyyy = mb_substr($given_date_of_birth,0, 4);
            $year_int  = (int) $year_yyyy;

            // Get month
            $month_mm  = mb_substr($given_date_of_birth,5, 2);
            $month_int = (int) $month_mm;

            // Get day
            $day_dd  = mb_substr($given_date_of_birth,8, 2);
            $day_int = (int) $day_dd;

            // Get delimiters
            $delimiter_1 = mb_substr($given_date_of_birth,4, 1);
            $delimiter_2 = mb_substr($given_date_of_birth,7, 1);

            // Check year is old enough
            $is_year_old_enough = $year_int <= $year_19_ago_int;
            if(!$is_year_old_enough){
                throw new Exception('date-of-birth-year-is-not-old-enough');
            }

            // Check year is new enough
            $is_year_new_enough = $year_int >= 1900;
            if(!$is_year_new_enough){
                throw new Exception('date-of-birth-year-is-not-new-enough');
            }

            // Check month is high enough
            $is_month_high_enough = $month_int > 0;
            if(!$is_month_high_enough){
                throw new Exception('date-of-birth-month-is-too-low');
            }

            // Check month is low enough
            $is_month_low_enough = $month_int < 13;
            if(!$is_month_low_enough){
                throw new Exception('date-of-birth-month-is-too-high');
            }

            // Check day is high enough
            $is_day_high_enough = $day_int > 0;
            if(!$is_day_high_enough){
                throw new Exception('date-of-birth-day-is-too-low');
            }

            // Check day is low enough
            $is_day_low_enough = $day_int < 32;
            if(!$is_day_low_enough){
                throw new Exception('date-of-birth-day-is-too-high');
            }

            $is_delimited_right = $delimiter_1 === '-' && $delimiter_2 === '-';
            if(!$is_delimited_right){
                throw new Exception('date-of-birth-delimiters-are-not-dashes');
            }

            $is_ok = true;
        }catch (Exception $e) {
            $is_ok       = false;
            $fail_reason = $e->getMessage();
        }

        // Build the response
        $response = [
            // 'date_of_birth'     => $given_date_of_birth,
            // 'yyyy'              => $year_yyyy,
            // 'mm'                => $month_mm,
            // 'dd'                => $day_dd,
            // 'current_year_yyyy' => $current_year_yyyy,
            // 'yyyy_19_years_ago' => $yyyy_19_years_ago,
            'is_allowed'        => $is_ok ? 'yes' : 'no',
            'fail_reason'       => $fail_reason,
        ];

        return $response;
    }

    /**
     * @param string $raw_password_string
     * @param string $confirm_raw_password_string
     * @return array
     */
    public function spotcheckNewUserPassword(string $raw_password_string, string $confirm_raw_password_string): array
    {
        $is_ok       = false;
        $fail_reason = '';

        // Continue on success, Stop on failure
        try{
            // Check if empty
            if(empty($raw_password_string)){
                throw new Exception('password-is-empty');
            }
            if(empty($confirm_raw_password_string)){
                throw new Exception('confirm-password-is-empty');
            }

            // Check that confirm matches
            $is_match = $raw_password_string === $confirm_raw_password_string;
            if(!$is_match){
                throw new Exception('confirm-password-does-not-match-password');
            }

            // Check if password is 10 chars or longer
            $password_length  = strlen($raw_password_string);
            $is_10_chars_plus = $password_length > 9;
            if(!$is_10_chars_plus){
                throw new Exception('password-is-too-short');
            }

            $is_ok = true;
        }catch (Exception $e) {
            $is_ok       = false;
            $fail_reason = $e->getMessage();
        }

        // Build the response
        $response = [
            // 'password'         => $raw_password_string,
            // 'confirm_password' => $confirm_raw_password_string,
            'is_ok'            => $is_ok ? 'yes' : 'no',
            'fail_reason'      => $fail_reason,
        ];

        return $response;
    }


    /**
     * @param string $username_unsafe
     * @param string $email_address_unsafe
     * @param string $new_password_unsafe
     * @param string $confirm_new_password_unsafe
     * @return array
     */
    public function spotcheckNewUserInfo(string $username_unsafe, string $email_address_unsafe, string $new_password_unsafe, string $confirm_new_password_unsafe): array
    {
        $is_username_available    = false;
        $is_email_address_allowed = false;
        //$is_date_of_birth_allowed = false;
        $is_password_ok           = false;

        $username_availability_info       = [];
        $email_address_acceptability_info = [];
        //$date_of_birth_acceptability_info = [];
        $password_acceptability_info      = [];

        $continue    = true;
        $fail_field  = '';
        $fail_reason = '';

        // Username
        $username_availability_info = $this->getUsernameAvailability($username_unsafe);
        $is_username_available      = $username_availability_info['is_available'] === 'yes';
        if(!$is_username_available){
            $continue    = false;
            $fail_field  = 'username';
            $fail_reason = $username_availability_info['fail_reason'];
        }

        // Email address
        if($continue){
            $email_address_acceptability_info = $this->spotcheckNewUserEmailAddress($email_address_unsafe);
            $is_email_address_allowed         = $email_address_acceptability_info['is_allowed'] === 'yes';
            if(!$is_email_address_allowed){
                $continue    = false;
                $fail_field  = 'email';
                $fail_reason = $email_address_acceptability_info['fail_reason'];
            }
        }

        // Date of birth
        //if($continue){
            // $date_of_birth_acceptability_info = $this->spotcheckNewUserDateOfBirth($date_of_birth_unsafe);
            // $is_date_of_birth_allowed         = $date_of_birth_acceptability_info['is_allowed'] === 'yes';
            // if(!$is_date_of_birth_allowed){
            //     $continue    = false;
            //     $fail_field  = 'birthday';
            //     $fail_reason = $date_of_birth_acceptability_info['fail_reason'];
            // }
        //}

        // Password
        if($continue){
            $password_acceptability_info = $this->spotcheckNewUserPassword($new_password_unsafe, $confirm_new_password_unsafe);
            $is_password_ok              = $password_acceptability_info['is_ok'] === 'yes';
            if(!$is_password_ok){
                $continue    = false;
                $fail_field  = 'password';
                $fail_reason = $password_acceptability_info['fail_reason'];
            }
        }

        $is_acceptable = $is_username_available && $is_email_address_allowed && $is_password_ok;

        // Build the response
        $response = [
            'username_availability_info'       => $username_availability_info,
            'email_address_acceptability_info' => $email_address_acceptability_info,
            // 'date_of_birth_acceptability_info' => $date_of_birth_acceptability_info,
            'password_acceptability_info'      => $password_acceptability_info,
            'is_acceptable'                    => $is_acceptable ? 'yes' : 'no',
            'fail_field'                       => $fail_field,
            'fail_reason'                      => $fail_reason,
        ];

        return $response;
    }

    public function createUser(string $username_unsafe, string $email_address, string $new_password, string $confirm_new_password): array
    {
        $user_creation_acceptability_info = $this->spotcheckNewUserInfo($username_unsafe, $email_address, $new_password, $confirm_new_password);
        $is_acceptable                    = $user_creation_acceptability_info['is_acceptable'] === 'yes';
        $fail_field                       = $user_creation_acceptability_info['fail_field'];
        $fail_reason                      = $user_creation_acceptability_info['fail_reason'];
        $user_creation_info               = [];
        $is_successful                    = false;

        if($is_acceptable){
            $username            = (string) $user_creation_acceptability_info['username_availability_info']['name_normalized'];
            $username_lower      = (string) $user_creation_acceptability_info['username_availability_info']['name_normalized_lower'];
            $password_hash       = $this->password_utility->getPasswordHash($new_password);
            $queue_id            = 0;
            $user_check_char     = '';
            $user_id             = 0;
            $username_id         = 0;
            $email_address_id    = 0;
            $password_id         = 0;
            $login_credential_id = 0;



            // Continue on success, Stop on failure
            try{
                /*
                // Insert new row to the User Creation Queue
                $queue_id     = $this->user_creation_queue_gateway->queueUserForCreation($username,  $username_lower,  $email_address,  $date_of_birth,  $password_hash);
                $has_queue_id = $queue_id > 0;
                if(!$has_queue_id){
                    throw new Exception('No queue id from User Creation Queue');
                }

                // Begin transaction
                $this->database->startTransaction();

                // Insert new row to Users
                $user_check_char = $this->random_char_utility->getRandomCheckCharVersion1();
                $user_id         = $this->user_gateway->createUser($user_check_char, $username_lower, $email_address);
                $has_user_id     = $user_id > 0;
                if(!$has_user_id){
                    throw new Exception('No user id returned when creating new User.');
                }

                // Tell the queue that the user was created
                $did_flag = $this->user_creation_queue_gateway->flagUserWasCreated($queue_id,  $user_id);
                if(!$did_flag){
                    throw new Exception('Failed to inform the queue that the user was created.');
                }

                // Insert new row to Usernames
                $username_id     = $this->username_gateway->createUsername($user_id, $username, $username_lower);
                $has_username_id = $username_id > 0;
                if(!$has_username_id){
                    throw new Exception('No username id returned when creating new Username.');
                }

                // Tell the queue that the username was created
                $did_flag = $this->user_creation_queue_gateway->flagUsernameWasCreated($queue_id, $username_id);
                if(!$did_flag){
                    throw new Exception('Failed to inform the queue that the username was added.');
                }

                // Insert new row to User Email Addresses
                $email_address_id     = $this->user_email_address_gateway->addUserEmailAddress($user_id, $email_address);
                $has_email_address_id = $email_address_id > 0;
                if(!$has_email_address_id){
                    throw new Exception('No email address id was returned when adding new User Email Address.');
                }

                // Tell the queue that the email address was added
                $did_flag = $this->user_creation_queue_gateway->flagUserEmailAddressWasAdded($queue_id, $email_address_id);
                if(!$did_flag){
                    throw new Exception('Failed to inform the queue that the user email address was added.');
                }

                // Insert new row to User Passwords
                $password_id     = $this->password_gateway->createPassword($user_id, $password_hash);
                $has_password_id = $password_id > 0;
                if(!$has_password_id){
                    throw new Exception('No password id returned when creating a new Password for User.');
                }

                // Tell the queue that the password was created
                $did_flag = $this->user_creation_queue_gateway->flagPasswordWasCreated($queue_id, $password_id);
                if(!$did_flag){
                    throw new Exception('Failed to inform the queue that the password was added.');
                }


                // Insert new row to User Login Credentials
                $login_credential_id = $this->login_credential_gateway->createLoginCredentialWithUsernameAndPassword($user_id, $username_id, $password_id);
                $has_login_credential_id = $login_credential_id > 0;
                if(!$has_login_credential_id){
                    throw new Exception('No login-credential id returned when creating new Login Credential for User.');
                }

                // Tell the queue that the login-credential was created
                $did_flag = $this->user_creation_queue_gateway->flagLoginCredentialWasCreated($queue_id, $login_credential_id);
                if(!$did_flag){
                    throw new Exception('Failed to inform the queue that the login-credential was added.');
                }

                // Insert new row to User Account Info
                $did_create_user_account_info = $this->user_account_info_gateway->createUserAccountInfo($user_id, $date_of_birth);
                if(!$did_create_user_account_info){
                    throw new Exception('Problem creating User Account Info.');
                }


                // Commit transaction
                $this->database->commitTransaction();
                */



                // Get check-char
                $user_check_char  = $this->random_char_utility->getRandomCheckCharVersion1();

                // Get ULID
                $user_ulid_object = Ulid::generate();
                $user_ulid        = (string) $user_ulid_object;
                $has_user_ulid    = strlen($user_ulid) === 26;
                if(!$has_user_ulid){
                    throw new Exception('Generated User ULID is not valid, must be 26 characters');
                }

                // Insert new row to Users
                $user_id         = $this->user_gateway->createUser($user_ulid, $user_check_char, $username, $username_lower, $email_address, $password_hash);
                $has_user_id     = $user_id > 0;
                if(!$has_user_id){
                    throw new Exception('No user id returned when creating new User.');
                }

                // Flag as successful
                $is_successful = true;
            }catch (Exception $e) {
                $fail_reason = $e->getMessage();
            }

            $user_creation_info = [
                'username'               => $username,
                'username_lower'         => $username_lower,
                'user_creation_queue_id' => $queue_id,
                'user_check_char'        => $user_check_char,
                'user_id'                => $user_id,
                'username_id'            => $username_id,
                'email_address_id'       => $email_address_id,
                'password_id'            => $password_id,
                'login_credential_id'    => $login_credential_id,
                'is_successful'          => $is_successful ? 'yes' : 'no',
            ];
        }

        // Build the response
        $response = [
            'user_creation_acceptability_info' => $user_creation_acceptability_info,
            'user_creation_info'               => $user_creation_info,
            'is_acceptable'                    => $is_acceptable ? 'yes' : 'no',
            'fail_field'                       => $fail_field,
            'fail_reason'                      => $fail_reason,
            'is_successful'                    => $is_successful ? 'yes' : 'no',
        ];

        return $response;
    }


    /**
     * @param string $given_username
     * @param string $given_password
     * @return array
     */
    public function getLoginValidationWithUsernameAndPassword(string $given_username, string $given_password): array
    {
        // Set defaults
        $r                            = [];
        $is_login_valid               = false;
        $fail_reason                  = '';
        $response_user_id             = 0;
        $response_username            = '';
        $response_username_lower      = '';



        try {
            // Look at given password
            $given_password_length         = mb_strlen($given_password);
            $is_given_password_long_enough = $given_password_length > 9;

            // Throw when the password is too short (This is to prevent lucky-guess collision attack)
            if(!$is_given_password_long_enough){
                throw new Exception('Bad password length.');
            }

            /*
            // Find user id
            $username_lower = $this->username_normalizer->getUsernameLower($given_username);
         // $user_id        = $this->username_gateway->findUserIdByUsernameLower($username_lower);
            $user_id        = $this->user_gateway->findUserIdByUsernameLower($username_lower);
            $has_user_id    = $user_id > 0;

            // Throw when the user id isn't found
            if(!$has_user_id){
                throw new Exception('No user id found.');
            }

            // Find the login credentials
            $user_login_credential     = $this->login_credential_gateway->getNewestLoginCredentialRowForUserByUserId($user_id);
            $has_user_login_credential = count($user_login_credential) > 0;

            // Throw when the login credentials aren't found
            if(!$has_user_login_credential){
                throw new Exception('No login credentials found.');
            }

            // Look at login credential info
            $login_credential_id             = (int) $user_login_credential['login_credential_id'];
            $login_credential_username       = (string) $user_login_credential['username'];
            $login_credential_username_lower = (string) $user_login_credential['username_lower'];
            $login_credential_password_hash  = (string) $user_login_credential['password_hash'];
            $login_credential_first_used     = (string) $user_login_credential['datetime_first_used'];

            // Throw when the username is not the user's current username
            $are_usernames_a_match = $username_lower === $login_credential_username_lower;
            if(!$are_usernames_a_match){
                throw new Exception('Username does not match login credential username.');
            }
            */

            // Get username_lower
            $given_username_lower = $this->username_normalizer->getUsernameLower($given_username);

            // Get the user row
            $user_row = $this->user_gateway->findUserRowByUsernameLower($given_username_lower);
            $found_user_row = !empty($user_row) && is_array($user_row);
            if(!$found_user_row){
                throw new Exception('Unable to find the user.');
            }

            // Get the user id
            $user_id = $user_row['user_id'];
            $has_user_id = !empty($user_id) && $user_id > 0;
            if(!$has_user_id){
                // Throw when the user id isn't found
                throw new Exception('No user id found.');
            }

            // Get the username
            $username = $user_row['username'];
            $username_lower = $user_row['username_lower'];

            // Get the password hash
            $user_row_password_hash = $user_row['password_hash'];
            $has_user_row_password_hash = !empty($user_row_password_hash) && strlen($user_row_password_hash);
            if(!$has_user_row_password_hash){
                throw new Exception('Stored password does not look correct, Abort.');
            }

            // Check password
            $is_password_a_match = password_verify($given_password, $user_row_password_hash);
            if(!$is_password_a_match){
                throw new Exception('Wrong password.');
            }

            $response_user_id        = $user_id;
            $response_username       = $username;
            $response_username_lower = $username_lower;
            $is_login_valid          = true;
        } catch (PithException | Exception $e) {
            $is_login_valid = false;
            $fail_reason    = $e->getMessage();
        }

        $r = [
            'is_login_valid_yn'   => $is_login_valid ? 'yes' : 'no',
            'fail_reason'         => $fail_reason,
            'user_id'             => $response_user_id,
            'username'            => $response_username,
            'username_lower'      => $response_username_lower,
            'login_time'          => time(),
        ];

        return $r;
    }

    /**
     * @param int $user_id
     * @return array
     */
    public function getUserAccessLevelsAboveUser(int $user_id): array
    {
        $user_access_levels_above_user = [];

        //$user_access_levels_above_user = $this->access_level_gateway->getUserAccessLevelsAboveUser($user_id);

        return $user_access_levels_above_user;
    }

}