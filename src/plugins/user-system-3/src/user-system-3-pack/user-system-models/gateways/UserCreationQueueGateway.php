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
 * User Creation Queue Gateway
 * ---------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable name are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpUnusedLocalVariableInspection      - Ignore for readability.
 * @noinspection PhpUnnecessaryLocalVariableInspection - Readability.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PSR 4 not 0.
 */


declare(strict_types=1);


namespace Pith\Framework\Plugin\UserSystem3;

use Exception;
use Pith\Framework\PithDatabaseWrapper;

/**
 * Class UsernameGateway
 */
class UserCreationQueueGateway
{
    private PithDatabaseWrapper $database;

    public function __construct(PithDatabaseWrapper $database)
    {
        $this->database = $database;
    }


    /**
     * @param  string $username
     * @param  string $username_lower
     * @param  string $email_address
     * @param  string $date_of_birth
     * @param  string $password_hash
     * @return int
     * @throws Exception
     */
    public function queueUserForCreation(string $username, string $username_lower, string $email_address, string $date_of_birth, string $password_hash): int
    {
        // Query
        $sql = '
            INSERT INTO `user_creation_queue` 
                (username, username_lower, email_address, datetime_birth_date, password_hash) 
            VALUES 
                (:username, :username_lower, :email_address, :datetime_birth_date, :password_hash) 
            ';

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':username'            => $username,
                ':username_lower'      => $username_lower,
                ':email_address'       => $email_address,
                ':datetime_birth_date' => $date_of_birth,
                ':password_hash'       => $password_hash,
            ]
        );

        // Get inserted id
        $inserted_id = $this->database->pdo->lastInsertId() ?: 0;

        if($inserted_id === 0){
            throw new Exception('Failed to insert to the User Creation Queue table.');
        }

        return (int) $inserted_id;
    }

    /**
     * @param $queue_id
     * @param $user_id
     * @return bool
     */
    public function flagUserWasCreated($queue_id, $user_id): bool
    {
        $sql = '
            UPDATE 
                user_creation_queue
            SET 
                datetime_user_created = NOW(),
                created_user_id = :user_id
            WHERE
                user_creation_queue_id = :user_creation_queue_id
            LIMIT 1
        ';

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':user_id'                => $user_id,
                ':user_creation_queue_id' => $queue_id,
            ]
        );

        $rows_affected = $statement->rowCount();
        $did_update    = $rows_affected > 0;

        return $did_update;
    }


    /**
     * @param int $queue_id
     * @param int $username_id
     * @return bool
     */
    public function flagUsernameWasCreated(int $queue_id, int $username_id): bool
    {
        $sql = '
            UPDATE 
                user_creation_queue
            SET 
                datetime_username_added = NOW(),
                created_username_id = :username_id
            WHERE
                user_creation_queue_id = :user_creation_queue_id
            LIMIT 1
        ';

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':username_id'            => $username_id,
                ':user_creation_queue_id' => $queue_id,
            ]
        );

        // Check rows affected
        $rows_affected = $statement->rowCount();
        $did_update    = $rows_affected > 0;

        // Return true if updated, else false
        return $did_update;
    }


    public function flagUserEmailAddressWasAdded(int $queue_id, int $email_address_id): bool
    {
        $sql = '
            UPDATE 
                user_creation_queue
            SET 
                datetime_email_address_added = NOW(),
                created_email_address_id = :email_address_id
            WHERE
                user_creation_queue_id = :queue_id
            LIMIT 1
        ';

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':email_address_id' => $email_address_id,
                ':queue_id'         => $queue_id,
            ]
        );

        // Check rows affected
        $rows_affected = $statement->rowCount();
        $did_update    = $rows_affected > 0;

        // Return true if updated, else false
        return $did_update;
    }


    public function flagPasswordWasCreated(int $queue_id, int $password_id): bool
    {
        $sql = '
            UPDATE 
                user_creation_queue
            SET 
                datetime_password_added = NOW(),
                created_password_id = :password_id
            WHERE
                user_creation_queue_id = :queue_id
            LIMIT 1
        ';

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':password_id' => $password_id,
                ':queue_id'    => $queue_id,
            ]
        );

        // Check rows affected
        $rows_affected = $statement->rowCount();
        $did_update    = $rows_affected > 0;

        // Return true if updated, else false
        return $did_update;
    }



    public function flagLoginCredentialWasCreated(int $queue_id, int $login_credential_id): bool
    {
        $sql = '
            UPDATE 
                user_creation_queue
            SET 
                datetime_login_credential_added = NOW(),
                created_login_credential_id = :login_credential_id
            WHERE
                user_creation_queue_id = :queue_id
            LIMIT 1
        ';

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':login_credential_id' => $login_credential_id,
                ':queue_id'            => $queue_id,
            ]
        );

        // Check rows affected
        $rows_affected = $statement->rowCount();
        $did_update    = $rows_affected > 0;

        // Return true if updated, else false
        return $did_update;
    }

}