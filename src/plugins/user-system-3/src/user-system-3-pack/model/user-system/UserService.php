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

namespace Pith\Framework\Plugin\UserSystem3;

use Exception;
use Pith\Framework\PithDatabaseWrapper;
use Pith\Framework\PithException;
use Pith\Framework\Utility\RandomCharUtility;

/**
 * Class UserService
 * @package Pith\Framework\Plugin\UserSystem3
 */
class UserService
{
    private AccessLevelGateway      $access_level_gateway;
    private PithDatabaseWrapper     $database;
    private LoginCredentialGateway  $login_credential_gateway;
    private PasswordGateway         $password_gateway;
    private PasswordUtility         $password_utility;
    private RandomCharUtility       $random_char_utility;
    private UserAccountInfoGateway  $user_account_info_gateway;
    private UserCreationQueueGateway $user_creation_queue_gateway;
    private UserEmailAddressGateway $user_email_address_gateway;
    private UserGateway             $user_gateway;
    private UsernameGateway         $username_gateway;
    private UsernameNormalizer      $username_normalizer;

    public function __construct(
        AccessLevelGateway $access_level_gateway,
        PithDatabaseWrapper $database,
        LoginCredentialGateway $login_credential_gateway,
        PasswordGateway $password_gateway,
        PasswordUtility $password_utility,
        RandomCharUtility $random_char_utility,
        UserAccountInfoGateway $user_account_info_gateway,
        UserCreationQueueGateway $user_creation_queue_gateway,
        UserEmailAddressGateway $user_email_address_gateway,
        UserGateway $user_gateway,
        UsernameGateway $username_gateway,
        UsernameNormalizer $username_normalizer
    ) {
        $this->access_level_gateway       = $access_level_gateway;
        $this->database                   = $database;
        $this->login_credential_gateway   = $login_credential_gateway;
        $this->password_gateway          = $password_gateway;
        $this->password_utility          = $password_utility;
        $this->random_char_utility       = $random_char_utility;
        $this->user_account_info_gateway = $user_account_info_gateway;
        $this->user_creation_queue_gateway = $user_creation_queue_gateway;
        $this->user_email_address_gateway = $user_email_address_gateway;
        $this->user_gateway              = $user_gateway;
        $this->username_gateway          = $username_gateway;
        $this->username_normalizer       = $username_normalizer;
    }

    /**
     * @param string $username
     * @param string $email_address
     * @param string $date_of_birth
     * @param string $password
     * @return array
     * @throws Exception
     */
    public function createNewUser(string $username, string $email_address, string $date_of_birth, string $password): array
    {
        // Default to failure
        $success = false;
        $user_id = 0;

        // Get username info
        $username_info = $this->username_normalizer->getNameInfo($username);
        if (!$username_info['name_is_valid']) {
            throw new Exception('Invalid username: ' . $username_info['error_message']);
        }

        // Get normalized username
        $username_normalized = $username_info['normalized_name'];
        $username_lower = $username_info['name_lower'];

        // Check if username is available
        $username_results = $this->username_gateway->findUsernameResults($username_normalized, $username_lower);
        if (count($username_results) > 0) {
            throw new Exception('Username is not available');
        }

        // Get password hash
        $password_hash = $this->password_utility->getPasswordHash($password);

        // Start transaction
        $this->database->pdo->beginTransaction();

        try {
            // Queue the user for creation
            $queue_id = $this->user_creation_queue_gateway->queueUserForCreation(
                $username_normalized,
                $username_lower,
                $email_address,
                $date_of_birth,
                $password_hash
            );

            // Create check char
            $check_char = $this->random_char_utility->getRandomChar();

            // Create user
            $user_id = $this->user_gateway->createUser($check_char, $username_lower, $email_address);

            // Flag user was created
            $this->user_creation_queue_gateway->flagUserWasCreated($queue_id, $user_id);

            // Create username
            $username_id = $this->username_gateway->createUsername($user_id, $username_normalized, $username_lower);

            // Flag username was created
            $this->user_creation_queue_gateway->flagUsernameWasCreated($queue_id, $username_id);

            // Add email address
            $email_address_id = $this->user_email_address_gateway->addUserEmailAddress($user_id, $email_address);

            // Flag email address was added
            $this->user_creation_queue_gateway->flagUserEmailAddressWasAdded($queue_id, $email_address_id);

            // Create password
            $password_id = $this->password_gateway->createPassword($user_id, $password_hash);

            // Flag password was created
            $this->user_creation_queue_gateway->flagPasswordWasCreated($queue_id, $password_id);

            // Create login credential
            $login_credential_id = $this->login_credential_gateway->createLoginCredentialWithUsernameAndPassword(
                $user_id,
                $username_id,
                $password_id
            );

            // Flag login credential was created
            $this->user_creation_queue_gateway->flagLoginCredentialWasCreated($queue_id, $login_credential_id);

            // Create user account info
            $this->user_account_info_gateway->createUserAccountInfo($user_id, $date_of_birth);

            // Commit transaction
            $this->database->pdo->commit();

            // Set success
            $success = true;

        } catch (Exception $e) {
            // Rollback transaction
            $this->database->pdo->rollBack();
            throw $e;
        }

        // Return result
        return [
            'success' => $success,
            'user_id' => $user_id,
        ];
    }

    /**
     * @param string $username_or_email
     * @param string $password
     * @return array
     * @throws PithException
     */
    public function attemptLogin(string $username_or_email, string $password): array
    {
        // Default to failure
        $success = false;
        $user_id = 0;

        // Get username lower
        $username_lower = $this->username_normalizer->getUsernameLower($username_or_email);

        // Try to get user id by username
        $user_id = $this->username_gateway->findUserIdByUsernameLower($username_lower);

        // If found user by username
        if ($user_id > 0) {
            // Get newest login credential
            $login_credential = $this->login_credential_gateway->getNewestLoginCredentialRowForUserByUserId($user_id);

            // If found login credential
            if (!empty($login_credential)) {
                // Get password hash
                $password_hash = $login_credential['password_hash'];

                // Verify password
                $password_verified = password_verify($password, $password_hash);

                // If password verified
                if ($password_verified) {
                    $success = true;
                }
            }
        }

        // Return result
        return [
            'success' => $success,
            'user_id' => $user_id,
        ];
    }

    /**
     * @param int $user_id
     * @return array
     */
    public function getUserAccessLevels(int $user_id): array
    {
        return $this->access_level_gateway->getUserAccessLevelsAboveUser($user_id);
    }

    /**
     * Get access levels above user
     * 
     * @param int $user_id
     * @return array
     */
    public function getUserAccessLevelsAboveUser(int $user_id): array
    {
        return $this->access_level_gateway->getUserAccessLevelsAboveUser($user_id);
    }

    /**
     * @param string $given_name
     * @return array
     */
    public function getUsernameAvailability(string $given_name): array
    {
        // Default to unavailable
        $is_available = false;
        $name_info = $this->username_normalizer->getNameInfo($given_name);

        if ($name_info['name_is_valid']) {
            $name = $name_info['normalized_name'];
            $name_lower = $name_info['name_lower'];

            try {
                $name_results = $this->username_gateway->findUsernameResults($name, $name_lower);
                $is_available = count($name_results) === 0;
            } catch (PithException $e) {
                $is_available = false;
            }
        }

        return [
            'name_is_valid' => $name_info['name_is_valid'],
            'error_message' => $name_info['error_message'],
            'is_available' => $is_available,
        ];
    }

    /**
     * @param string $given_email_address
     * @return array
     */
    public function spotcheckNewUserEmailAddress(string $given_email_address): array
    {
        $is_ok = true;
        $error_message = '';

        try {
            if (empty($given_email_address)) {
                throw new Exception('Email address is empty');
            }

            $email_address_char_length = mb_strlen($given_email_address);
            $at_sign_position = mb_strpos($given_email_address, '@');

            if ($at_sign_position === false) {
                throw new Exception('Email address does not have @ sign');
            }

            if ($at_sign_position === 0) {
                throw new Exception('Email address does not have name part');
            }

            if (!($email_address_char_length - 3 > $at_sign_position)) {
                throw new Exception('Email address does not have domain part');
            }

            $domain = mb_substr($given_email_address, $at_sign_position + 1);
            $domain_char_length = mb_strlen($domain);
            $dot_position = mb_strpos($domain, '.');

            if ($dot_position === false) {
                throw new Exception('Email address domain does not have dot');
            }

            if ($dot_position === 0) {
                throw new Exception('Email address has dot at start of domain');
            }

            if (!($domain_char_length - 1 > $dot_position)) {
                throw new Exception('Email address has dot at end of domain');
            }
        } catch (Exception $e) {
            $is_ok = false;
            $error_message = $e->getMessage();
        }

        return [
            'is_valid' => $is_ok,
            'error_message' => $error_message,
        ];
    }

    /**
     * @param string $given_date_of_birth
     * @return array
     */
    public function spotcheckNewUserDateOfBirth(string $given_date_of_birth): array
    {
        $is_ok = true;
        $error_message = '';

        try {
            if (empty($given_date_of_birth)) {
                throw new Exception('Date of birth is empty');
            }

            if (strlen($given_date_of_birth) !== 10) {
                throw new Exception('Date of birth is not in YYYY-MM-DD format');
            }

            $year = (int) mb_substr($given_date_of_birth, 0, 4);
            $month = (int) mb_substr($given_date_of_birth, 5, 2);
            $day = (int) mb_substr($given_date_of_birth, 8, 2);

            $current_year = (int) date('Y');
            $min_year = 1900;
            $max_year = $current_year - 19;

            if ($year < $min_year) {
                throw new Exception('Birth year is too old');
            }

            if ($year > $max_year) {
                throw new Exception('Must be at least 19 years old');
            }

            if ($month < 1 || $month > 12) {
                throw new Exception('Invalid birth month');
            }

            if ($day < 1 || $day > 31) {
                throw new Exception('Invalid birth day');
            }

            // Additional validation for days in month
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            if ($day > $days_in_month) {
                throw new Exception('Invalid day for the given month and year');
            }

        } catch (Exception $e) {
            $is_ok = false;
            $error_message = $e->getMessage();
        }

        return [
            'is_valid' => $is_ok,
            'error_message' => $error_message,
        ];
    }

    /**
     * @param string $raw_password_string
     * @param string $confirm_raw_password_string
     * @return array
     */
    public function spotcheckNewUserPassword(string $raw_password_string, string $confirm_raw_password_string): array
    {
        $is_ok = true;
        $error_message = '';

        try {
            if (empty($raw_password_string)) {
                throw new Exception('Password is empty');
            }

            if (empty($confirm_raw_password_string)) {
                throw new Exception('Confirmation password is empty');
            }

            if ($raw_password_string !== $confirm_raw_password_string) {
                throw new Exception('Passwords do not match');
            }

            $password_length = mb_strlen($raw_password_string);
            if ($password_length < 8) {
                throw new Exception('Password must be at least 8 characters long');
            }

            if ($password_length > 72) {
                throw new Exception('Password cannot be longer than 72 characters');
            }

        } catch (Exception $e) {
            $is_ok = false;
            $error_message = $e->getMessage();
        }

        return [
            'is_valid' => $is_ok,
            'error_message' => $error_message,
        ];
    }

    /**
     * @param string $username_unsafe
     * @param string $email_address_unsafe
     * @param string $date_of_birth_unsafe
     * @param string $new_password_unsafe
     * @param string $confirm_new_password_unsafe
     * @return array
     */
    public function spotcheckNewUserInfo(
        string $username_unsafe,
        string $email_address_unsafe,
        string $date_of_birth_unsafe,
        string $new_password_unsafe,
        string $confirm_new_password_unsafe
    ): array {
        $is_ok = true;
        $error_message = '';
        $error_field = '';

        try {
            // Check username
            $username_availability = $this->getUsernameAvailability($username_unsafe);
            if (!$username_availability['name_is_valid']) {
                throw new Exception($username_availability['error_message'], 1);
            }
            if (!$username_availability['is_available']) {
                throw new Exception('Username is not available', 1);
            }

            // Check email
            $email_check = $this->spotcheckNewUserEmailAddress($email_address_unsafe);
            if (!$email_check['is_valid']) {
                $error_field = 'email';
                throw new Exception($email_check['error_message'], 2);
            }

            // Check date of birth
            $dob_check = $this->spotcheckNewUserDateOfBirth($date_of_birth_unsafe);
            if (!$dob_check['is_valid']) {
                $error_field = 'date_of_birth';
                throw new Exception($dob_check['error_message'], 3);
            }

            // Check password
            $password_check = $this->spotcheckNewUserPassword($new_password_unsafe, $confirm_new_password_unsafe);
            if (!$password_check['is_valid']) {
                $error_field = 'password';
                throw new Exception($password_check['error_message'], 4);
            }

        } catch (Exception $e) {
            $is_ok = false;
            $error_message = $e->getMessage();
            if (empty($error_field)) {
                $error_field = 'username';
            }
        }

        return [
            'is_valid' => $is_ok,
            'error_message' => $error_message,
            'error_field' => $error_field,
        ];
    }

    /**
     * @param string $given_username
     * @param string $given_password
     * @return array
     * @throws PithException
     */
    public function getLoginValidationWithUsernameAndPassword(string $given_username, string $given_password): array
    {
        // Default to failure
        $success = false;
        $user_id = 0;
        $error_message = '';

        // Get username lower
        $username_lower = $this->username_normalizer->getUsernameLower($given_username);

        // Try to get user id by username
        $user_id = $this->username_gateway->findUserIdByUsernameLower($username_lower);

        // If found user by username
        if ($user_id > 0) {
            // Get newest login credential
            $login_credential = $this->login_credential_gateway->getNewestLoginCredentialRowForUserByUserId($user_id);

            // If found login credential
            if (!empty($login_credential)) {
                // Get password hash
                $password_hash = $login_credential['password_hash'];

                // Verify password
                $password_verified = password_verify($given_password, $password_hash);

                // If password verified
                if ($password_verified) {
                    $success = true;
                } else {
                    $error_message = 'Invalid password';
                }
            } else {
                $error_message = 'No login credentials found';
            }
        } else {
            $error_message = 'Username not found';
        }

        // Return result
        return [
            'success' => $success,
            'user_id' => $user_id,
            'error_message' => $error_message,
        ];
    }
} 