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
 * Impression Log Loading Queue Gateway
 * ------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable name are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PSR 4 not 0.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\ImpressionSystem;

use Exception;
use PDO;
use PDOException;
use Pith\Framework\PithDatabaseWrapper;
use Pith\Framework\PithException;

/**
 * Class ImpressionLogLoadingQueueGateway
 * @package Pith\Framework\SharedInfrastructure\Model\ImpressionSystem
 */
class ImpressionLogLoadingQueueGateway
{
    private PithDatabaseWrapper $database;

    public function __construct(PithDatabaseWrapper $database)
    {
        $this->database = $database;
    }

    /**
     * @param string $file_name
     * @return bool
     * @throws PithException
     */
    public function isImpressionLogFileQueuedForImport(string $file_name): bool
    {
        // Default to false
        $is_queued_for_import = false;

        // Query
        $sql = '
            SELECT
                *
            FROM
                `impression_log_loading_queue` AS q 
            WHERE
                q.log_file_name = :log_file_name
            LIMIT 1
            ';

        // Connect if not connected
        $this->database->connectOnce();

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':log_file_name' => $file_name,
            ]
        );

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $row_count = $results ? count($results) : 0;
        $is_queued_for_import = $row_count > 0;

        // Return ture if the file is in the queue, else return false if the file is not in the queue
        return $is_queued_for_import;
    }

    /**
     * @param string $file_name
     * @return int
     * @throws PithException
     * @throws Exception
     */
    public function addImpressionLogFileToQueueForImport(string $file_name): int
    {
        // Default to zero
        $inserted_id = 0;

        // Query
        $sql = '
            INSERT INTO `impression_log_loading_queue`
            (
                log_file_name, 
                datetime_added_to_queue
            )
            VALUES
            (
                :log_file_name, 
                NOW() 
            )
            ';

        // Connect if not connected
        $this->database->connectOnce();

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':log_file_name' => $file_name,
            ]
        );

        // Get inserted id
        $inserted_id = $this->database->pdo->lastInsertId() ?: 0;
        if($inserted_id === 0){
            throw new Exception('Failed to insert to queue.');
        }

        // Return the inserted id
        return (int) $inserted_id;
    }

}