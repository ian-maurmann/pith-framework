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
 * Username Gateway
 * ----------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable name are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\UserSystem;

use Pith\Framework\PithDatabaseWrapper;
use Pith\Framework\PithException;

/**
 * Class UsernameGateway
 * @package Pith\Framework\SharedInfrastructure\Model\UserSystem
 */
class UsernameGateway
{
    private PithDatabaseWrapper $database;

    public function __construct(PithDatabaseWrapper $database)
    {
        $this->database = $database;
    }


    /**
     * @throws PithException
     */
    public function getUsernameRowByNormalizedUsername($normalized_username): array
    {
        // Default to empty array
        $row = [];

        // Query
        $sql = '
            SELECT 
                * 
            FROM 
                user_login_usernames
            WHERE 
                username_normalized = ?
            LIMIT 1';

        // Execute
        $results = $this->database->query($sql, $normalized_username);

        // Check results, Get row
        $has_results = is_array($results) && (count($results) > 0);
        if($has_results){
            $row = $results[0];
        }

        // Return row as array when found, return empty array when not found
        return $row;
    }
}