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
 * Login Credential Gateway
 * ------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable name are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PSR 4 not 0.
 * @noinspection PhpUnusedLocalVariableInspection      - Ignore for readability.
 */


declare(strict_types=1);


namespace Pith\Framework\Plugin\UserSystem3;

use Exception;
use Pith\Framework\PithDatabaseWrapper;
use Pith\Framework\PithException;

/**
 * Class LoginCredentialGateway
 */
class LoginCredentialGateway
{
    private PithDatabaseWrapper $database;

    public function __construct(PithDatabaseWrapper $database)
    {
        $this->database = $database;
    }


    /**
     * @throws Exception
     */
    public function createLoginCredentialWithUsernameAndPassword(int $user_id, int $username_id, int $password_id): int
    {
        // Query
        $sql = '
            INSERT INTO `user_login_credentials` 
                (user_id, username_id, password_id) 
            VALUES 
                (:user_id, :username_id, :password_id) 
            ';

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':user_id'     => $user_id,
                ':username_id' => $username_id,
                ':password_id' => $password_id,
            ]
        );

        // Get inserted id
        $inserted_id = $this->database->pdo->lastInsertId() ?: 0;
        if($inserted_id === 0){
            throw new Exception('Failed to insert to the user_login_credentials table.');
        }

        // Return the inserted id
        return (int) $inserted_id;
    }

    /**
     * @param int $user_id
     * @return array
     * @throws PithException
     */
    public function getNewestLoginCredentialRowForUserByUserId(int $user_id): array
    {
        // Default to empty array
        $results = [];
        $row     = [];

        // Query
        $sql = '
            SELECT 
                c.login_credential_id,
                c.user_id,
                n.username,
                n.username_lower,
                p.password_hash,
                c.datetime_created,
                c.datetime_first_used
            FROM 
                user_login_credentials as c
            LEFT JOIN 
                user_login_usernames as n on c.username_id = n.username_id
            LEFT JOIN
                user_login_passwords as p on c.password_id = p.password_id
            WHERE 
                c.user_id = ?
            ORDER BY c.datetime_created DESC
            LIMIT 1
            ';

        // Execute
        $results = $this->database->query($sql, $user_id);

        // Check for results
        $has_results = is_array($results) && (count($results) > 0);
        if($has_results){
            $row = $results[0];
        }

        return $row;
    }
}