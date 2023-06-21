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
 * User Creation Queue Gateway
 * ---------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable name are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpUnusedLocalVariableInspection      - Ignore for readability.
 * @noinspection PhpUnnecessaryLocalVariableInspection - Readability.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\UserSystem;

use Exception;
use Pith\Framework\PithDatabaseWrapper;

/**
 * Class UsernameGateway
 * @package Pith\Framework\SharedInfrastructure\Model\UserSystem
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
}