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


namespace Pith\Framework\SharedInfrastructure\Model\UserSystem;

use Exception;
use Pith\Framework\PithDatabaseWrapper;
use Pith\Framework\PithException;

/**
 * Class LoginCredentialGateway
 * @package Pith\Framework\SharedInfrastructure\Model\UserSystem
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
}