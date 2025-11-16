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
 * User Role gateway
 * -----------------
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
use Pith\Framework\PithPostgresWrapper;
use Pith\Framework\PithException;

/**
 * Class UserRoleGateway
 */
class UserRoleGateway
{
    private PithPostgresWrapper $database;

    public function __construct(PithPostgresWrapper $database)
    {
        $this->database = $database;
    }

    /**
     * @throws PithException
     */
    public function getUserRoles($user_id): array
    {
        // Default to empty array
        $user_role_names = [];

        // Query
        $sql = '
            SELECT 
                r.role_name
            FROM 
                pith_user_roles AS ur
            JOIN pith_roles AS r
                ON ur.role_id = r.role_id
            WHERE 
                ur.user_id = ?
            ';

        // Execute
        $results = $this->database->query($sql, $user_id);

        // Check for results
        $has_results = is_array($results) && (count($results) > 0);

        // Loop through the results, Add role names
        if($has_results){
            foreach ($results as $result){
                $user_role_names[] = $result['role_name'];
            }
        }

        // Return list of user role names, else returns an empty array
        return $user_role_names;
    }
}