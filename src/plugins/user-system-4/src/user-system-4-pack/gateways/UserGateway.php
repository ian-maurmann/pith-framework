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
 * User Gateway
 * ------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable name are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PSR 4 not 0.
 * @noinspection PhpTooManyParametersInspection        - Methods with a large number of parameters are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\Plugin\UserSystem4;

use Exception;
use PDOException;
use Pith\Framework\PithDatabaseWrapper;
use Pith\Framework\PithException;

/**
 * Class UserGateway
 */
class UserGateway
{
    private PithDatabaseWrapper $database;

    public function __construct(PithDatabaseWrapper $database)
    {
        $this->database = $database;
    }


    /**
     * @param $name
     * @param $name_lower
     * @return array
     * @throws PithException
     */
    public function findUsernameResults($name, $name_lower): array
    {
        // Default to empty array
        $results = [];

        // Query
        $sql = '
            SELECT 
                * 
            FROM 
                users
            WHERE 
                username = ?
                OR 
                username_lower = ?
            ';

        // Execute
        $results = $this->database->query($sql, $name, $name_lower);

        // Check for results
        $has_results = is_array($results) && (count($results) > 0);
        if(!$has_results){
            $results = [];
        }

        return $results;
    }


    /**
     * @param string $user_ulid
     * @param string $check_char
     * @param string $username
     * @param string $username_lower
     * @param string $email_address
     * @param string $password_hash
     * @return int
     * @throws Exception
     */
    public function createUser(string $user_ulid, string $check_char, string $username, string $username_lower, string $email_address, string $password_hash): int
    {
        // Query
        $sql = '
            INSERT INTO `users` 
                (`user_ulid`, `check_char`, `username`, `username_lower`, `primary_email_address`, `password_hash`) 
            VALUES 
                (:user_ulid,  :check_char,  :username,  :username_lower,  :primary_email_address,  :password_hash) 
            ';

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':user_ulid'             => $user_ulid,
                ':check_char'            => $check_char,
                ':username'              => $username,
                ':username_lower'        => $username_lower,
                ':primary_email_address' => $email_address,
                ':password_hash'         => $password_hash,
            ]
        );

        // Get inserted id
        $inserted_id = $this->database->pdo->lastInsertId() ?: 0;
        if($inserted_id === 0){
            throw new Exception('Failed to insert to the User table.');
        }

        // Return the inserted id
        return (int) $inserted_id;
    }

    /**
     * @throws PithException
     */
    public function findUserIdByUsernameLower(string $username_lower): int
    {
        // Default to empty
        $results = [];
        $user_id = 0;

        // Query
        $sql = '
            SELECT 
                user_id
            FROM 
                users
            WHERE 
                username_lower = ?
            LIMIT 1
            ';

        // Execute
        $results = $this->database->query($sql, $username_lower);

        // Check for results
        $has_results = is_array($results) && (count($results) > 0);
        if($has_results){
            $row     = $results[0];
            $user_id = (int) $row['user_id'];
        }

        // Return user id as int if found, else return zero if not found
        return $user_id;
    }

    public function findUserRowByUsernameLower(string $username_lower): ?array
    {
        // Default to null
        $user_row = null;

        // Query
        $sql = '
            SELECT 
                *
            FROM 
                users
            WHERE 
                username_lower = ?
            LIMIT 1
            ';

        // Execute
        $results = $this->database->query($sql, $username_lower);

        // Check for results
        $has_results = is_array($results) && (count($results) > 0);
        if($has_results){
            $user_row = $results[0];
        }

        // Return user id as int if found, else return zero if not found
        return $user_row;
    }
}