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
 * Impression Gateway
 * ------------------
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
 * Class ImpressionGateway
 * @package Pith\Framework\SharedInfrastructure\Model\ImpressionSystem
 */
class ImpressionGateway
{
    private PithDatabaseWrapper $database;

    public function __construct(PithDatabaseWrapper $database)
    {
        $this->database = $database;
    }



    /**
     * @throws PithException
     * @throws Exception
     */
    public function insertImpression(
        string $impression_datetime,
        string $impression_http_method,
        string $impression_uri,
        int    $impression_port_as_int,
        string $impression_access_level,
        int    $was_allowed_01,
        string $impression_remote_ip_address,
        string $impression_session_id,
        int    $was_logged_user_01,
        int    $impression_user_id_int,
        string $impression_user_agent_string,
        string $ch_ua,
        string $ch_ua_platform,
        string $ch_ua_platform_version,
        string $ch_ua_mobile,
        string $ch_ua_model,
        string $ch_ua_architecture,
        string $ch_ua_bitness,
        string $client_accept_language_string,
        string $referer_string,
        string $ch_downlink,
        string $ch_viewport_width,
        string $ch_prefers_color_scheme
    ): int
    {
        // Default to zero
        $inserted_id = 0;

        // Query
        $sql = '
            INSERT INTO `impressions`
            (
                time, 
                http_method, 
                uri, 
                port, 
                access_level, 
                is_allowed, 
                ip, 
                session_id, 
                is_logged_user, 
                user_id, 
                user_agent_string, 
                ch_ua, 
                ch_ua_platform, 
                ch_ua_platform_version, 
                ch_ua_mobile, 
                ch_ua_model, 
                ch_ua_architecture, 
                ch_ua_bitness, 
                accept_language, 
                referer, 
                ch_downlink, 
                ch_viewport_width, 
                ch_prefers_color_scheme
            )
            VALUES
            (
                :time, 
                :http_method, 
                :uri, 
                :port, 
                :access_level, 
                :is_allowed, 
                :ip, 
                :session_id, 
                :is_logged_user, 
                :user_id, 
                :user_agent_string, 
                :ch_ua, 
                :ch_ua_platform, 
                :ch_ua_platform_version, 
                :ch_ua_mobile, 
                :ch_ua_model, 
                :ch_ua_architecture, 
                :ch_ua_bitness, 
                :accept_language, 
                :referer, 
                :ch_downlink, 
                :ch_viewport_width, 
                :ch_prefers_color_scheme
            )
            ';

        // Connect if not connected
        $this->database->connectOnce();

        // Prepare
        $statement = $this->database->pdo->prepare($sql);

        // Execute
        $statement->execute(
            [
                ':time'                    => $impression_datetime,
                ':http_method'             => $impression_http_method,
                ':uri'                     => $impression_uri,
                ':port'                    => $impression_port_as_int,
                ':access_level'            => $impression_access_level,
                ':is_allowed'              => $was_allowed_01,
                ':ip'                      => $impression_remote_ip_address,
                ':session_id'              => $impression_session_id,
                ':is_logged_user'          => $was_logged_user_01,
                ':user_id'                 => $impression_user_id_int,
                ':user_agent_string'       => $impression_user_agent_string,
                ':ch_ua'                   => $ch_ua,
                ':ch_ua_platform'          => $ch_ua_platform,
                ':ch_ua_platform_version'  => $ch_ua_platform_version,
                ':ch_ua_mobile'            => $ch_ua_mobile,
                ':ch_ua_model'             => $ch_ua_model,
                ':ch_ua_architecture'      => $ch_ua_architecture,
                ':ch_ua_bitness'           => $ch_ua_bitness,
                ':accept_language'         => $client_accept_language_string,
                ':referer'                 => $referer_string,
                ':ch_downlink'             => $ch_downlink,
                ':ch_viewport_width'       => $ch_viewport_width,
                ':ch_prefers_color_scheme' => $ch_prefers_color_scheme
            ]
        );

        // Get inserted id
        $inserted_id = $this->database->pdo->lastInsertId() ?: 0;
        if($inserted_id === 0){
            throw new Exception('Failed to insert new row.');
        }

        // Return the inserted id
        return (int) $inserted_id;
    }

}