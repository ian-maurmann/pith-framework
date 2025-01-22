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
 * User Account Info Gateway
 * -------------------------
 *
 * @noinspection PhpClassNamingConventionInspection     - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection  - Short variable name are ok.
 * @noinspection PhpMethodNamingConventionInspection    - Long method names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection       - Ignore, using PSR 4 not 0.
 * @noinspection PhpUnusedLocalVariableInspection       - Ignore for readability.
 * @noinspection PhpSingleStatementWithBracesInspection - Ignore unless you're an evil movie villain.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\UserSystem;

use Exception;
use Pith\Framework\PithDatabaseWrapper;
use Pith\Framework\PithException;

/**
 * Class UserAccountInfoGateway
 * @package Pith\Framework\SharedInfrastructure\Model\UserSystem
 */
class UserAccountInfoGateway
{
    private PithDatabaseWrapper $database;

    public function __construct(PithDatabaseWrapper $database)
    {
        $this->database = $database;
    }


    /**
     * @param int $user_id
     * @param string $date_of_birth
     * @return bool
     * @throws Exception
     */
    public function createUserAccountInfo(int $user_id, string $date_of_birth): bool
    {
        // Query
        $sql = '
            INSERT INTO `user_account_info` 
                (user_id, user_date_of_birth) 
            VALUES 
                (:user_id, :user_date_of_birth) 
            ';

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':user_id'            => $user_id,
                ':user_date_of_birth' => $date_of_birth,
            ]
        );

        // Since no auto-inc, instead of checking last inserted id, we check rows affected
        $rows_affected = $statement->rowCount();
        $did_insert    = $rows_affected > 0;
        if(!$did_insert){
            throw new Exception('Failed to insert to the User Account Info table.');
        }

        // Return true if inserted
        return $did_insert;
    }
}