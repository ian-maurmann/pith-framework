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
 * User Gateway
 * ------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable name are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\UserSystem;

use Exception;
use PDOException;
use Pith\Framework\PithDatabaseWrapper;
use Pith\Framework\PithException;

/**
 * Class UserGateway
 * @package Pith\Framework\SharedInfrastructure\Model\UserSystem
 */
class UserGateway
{
    private PithDatabaseWrapper $database;

    public function __construct(PithDatabaseWrapper $database)
    {
        $this->database = $database;
    }


    /**
     * @param string $check_char
     * @param string $username_lower
     * @param string $email_address
     * @return int
     * @throws Exception
     * @throws PDOException
     */
    public function createUser(string $check_char, string $username_lower, string $email_address): int
    {
        // Query
        $sql = '
            INSERT INTO `users` 
                (check_char, created_with_username_lower, created_with_email_address) 
            VALUES 
                (:check_char, :created_with_username_lower, :created_with_email_address) 
            ';

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':check_char'                  => $check_char,
                ':created_with_username_lower' => $username_lower,
                ':created_with_email_address'  => $email_address,
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

}