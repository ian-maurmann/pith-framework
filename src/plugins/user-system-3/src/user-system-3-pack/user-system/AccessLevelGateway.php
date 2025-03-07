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
 * Access Level Gateway
 * --------------------
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
use PDO;
use Pith\Framework\PithDatabaseWrapper;
use Pith\Framework\PithException;

/**
 * Class PasswordGateway
 */
class AccessLevelGateway
{
    private PithDatabaseWrapper $database;

    public function __construct(PithDatabaseWrapper $database)
    {
        // Set object dependencies
        $this->database = $database;
    }


    /**
     * @param int $user_id
     * @return array
     */
    public function getUserAccessLevelsAboveUser(int $user_id): array
    {
        // Default to empty list of access levels
        $user_access_levels_above_user = [];

        // Query
        $sql = '
            SELECT
                u.user_id AS user_id,
                webmasters.access_level_linker_id AS `webmaster_id`
            FROM 
                `users` AS u
            LEFT JOIN
                `access_level_webmaster_users` AS webmasters ON webmasters.user_id = u.user_id
            WHERE 
                u.`user_id` = :user_id
            ';

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':user_id' => $user_id,
            ]
        );

        // Get results
        $rows          = $statement->fetchAll(PDO::FETCH_ASSOC);
        $did_find_rows = $rows && count($rows);

        if($did_find_rows){
            // Get row
            $row = $rows[0];

            // Get access level linker ids
            $webmaster_id = $row['webmaster_id'] ? (int) $row['webmaster_id'] : 0;

            // Get if has the access level
            $is_webmaster = $webmaster_id > 0;

            // Add access level to list
            if($is_webmaster){
                $user_access_levels_above_user[] = 'webmaster';
            }
        }

        return $user_access_levels_above_user;
    }
}