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
 * User Service
 * ------------
 *
 * @noinspection PhpPropertyNamingConventionInspection      - Long property names are ok.
 * @noinspection PhpMethodNamingConventionInspection        - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection      - Short variable names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection      - Ignore for readability.
 * @noinspection PhpArrayShapeAttributeCanBeAddedInspection - Ignore shape for now, add later.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\UserSystem;

use Exception;
use Pith\Framework\PithException;

/**
 * Class UserService
 * @package Pith\Framework\SharedInfrastructure\Model\UserSystem
 */
class UserService
{
    private PasswordUtility          $password_utility;
    private UserCreationQueueGateway $user_creation_queue_gateway;
    private UsernameGateway          $username_gateway;
    private UsernameNormalizer       $username_normalizer;

    public function __construct(PasswordUtility $password_utility, UserCreationQueueGateway $user_creation_queue_gateway, UsernameGateway $username_gateway, UsernameNormalizer $username_normalizer)
    {
        // Set object dependencies:
        $this->password_utility            = $password_utility;
        $this->user_creation_queue_gateway = $user_creation_queue_gateway;
        $this->username_gateway            = $username_gateway;
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
                $name_results     = $this->username_gateway->findUsernameResults($name, $name_lower);
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
     * @param string $given_raw_password_string
     * @param string $confirm_password_string
     */
    public function spotcheckNewUserPassword(string $raw_password_string, string $confirm_raw_password_string)
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
     * @param $username_unsafe
     * @param $email_address_unsafe
     * @param $date_of_birth_unsafe
     * @param $new_password_unsafe
     * @param $confirm_new_password_unsafe
     * @return array
     */
    public function spotcheckNewUserInfo(string $username_unsafe, string $email_address_unsafe, string $date_of_birth_unsafe, string $new_password_unsafe, string $confirm_new_password_unsafe): array
    {
        $is_username_available    = false;
        $is_email_address_allowed = false;
        $is_date_of_birth_allowed = false;
        $is_password_ok           = false;

        $username_availability_info       = [];
        $email_address_acceptability_info = [];
        $date_of_birth_acceptability_info = [];
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
        if($continue){
            $date_of_birth_acceptability_info = $this->spotcheckNewUserDateOfBirth($date_of_birth_unsafe);
            $is_date_of_birth_allowed         = $date_of_birth_acceptability_info['is_allowed'] === 'yes';
            if(!$is_date_of_birth_allowed){
                $continue    = false;
                $fail_field  = 'birthday';
                $fail_reason = $date_of_birth_acceptability_info['fail_reason'];
            }
        }

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

        $is_acceptable = $is_username_available && $is_email_address_allowed && $is_date_of_birth_allowed && $is_password_ok;


        // Build the response
        $response = [
            'username_availability_info'       => $username_availability_info,
            'email_address_acceptability_info' => $email_address_acceptability_info,
            'date_of_birth_acceptability_info' => $date_of_birth_acceptability_info,
            'password_acceptability_info'      => $password_acceptability_info,
            'is_acceptable'                    => $is_acceptable ? 'yes' : 'no',
            'fail_field'                       => $fail_field,
            'fail_reason'                      => $fail_reason,
        ];

        return $response;
    }

    public function createUser(string $username_unsafe, string $email_address_unsafe, string $date_of_birth_unsafe, string $new_password_unsafe, string $confirm_new_password_unsafe): array
    {
        $user_creation_acceptability_info = $this->spotcheckNewUserInfo($username_unsafe, $email_address_unsafe, $date_of_birth_unsafe, $new_password_unsafe, $confirm_new_password_unsafe);
        $is_acceptable                    = $user_creation_acceptability_info['is_acceptable'] === 'yes';
        $fail_field                       = $user_creation_acceptability_info['fail_field'];
        $fail_reason                      = $user_creation_acceptability_info['fail_reason'];

        if($is_acceptable){
            $username       = (string) $user_creation_acceptability_info['username_availability_info']['name_normalized'];
            $username_lower = (string) $user_creation_acceptability_info['username_availability_info']['name_normalized_lower'];
            $password_hash  = $this->password_utility->getPasswordHash($new_password_unsafe);

            $queue_info = $this->queueUserCreation($username,  $username_lower,  $email_address_unsafe,  $date_of_birth_unsafe,  $password_hash);
            $queue_id = $queue_info['queue_id'];
        }

        // Build the response
        $response = [
            'user_creation_acceptability_info' => $user_creation_acceptability_info,
            'is_acceptable'                    => $is_acceptable ? 'yes' : 'no',
            'fail_field'                       => $fail_field,
            'fail_reason'                      => $fail_reason,
        ];

        return $response;
    }

    public function queueUserCreation(string $username, string $username_lower, string $email_address, string $date_of_birth, string $password_hash): array
    {
        $is_ok       = false;
        $fail_reason = '';
        $queue_id    = 0;

        try{
            $queue_id = $this->user_creation_queue_gateway->queueUserForCreation($username,  $username_lower,  $email_address,  $date_of_birth,  $password_hash);
            $is_ok = $queue_id > 0;
        }catch (Exception $e) {
            $is_ok       = false;
            $fail_reason = $e->getMessage();
        }


        // Build the response
        $response = [
            'is_ok'       => $is_ok,
            'fail_reason' => $fail_reason,
            'queue_id'    => $queue_id,
        ];

        return $response;
    }
}