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
 * Impression Service
 * ------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection      - Long property names are ok.
 * @noinspection PhpMethodNamingConventionInspection        - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection      - Short variable names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection      - Ignore for readability.
 * @noinspection PhpArrayShapeAttributeCanBeAddedInspection - Ignore shape for now, add later.
 * @noinspection PhpIllegalPsrClassPathInspection           - Ignore, using PSR 4 not 0.
 * @noinspection PhpUnusedLocalVariableInspection           - Readability.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\ImpressionSystem;

use Exception;
use Pith\Framework\PithException;

/**
 * Class ImpressionService
 * @package Pith\Framework\SharedInfrastructure\Model\ImpressionSystem
 */
class ImpressionService
{
    private ImpressionGateway                $impression_gateway;
    private ImpressionLogLoadingQueueGateway $impression_log_loading_queue_gateway;
    private UniqueDailyViewGateway           $unique_daily_view_gateway;

    public function __construct(ImpressionGateway $impression_gateway, ImpressionLogLoadingQueueGateway $impression_log_loading_queue_gateway, UniqueDailyViewGateway $unique_daily_view_gateway)
    {
        // Set object dependencies:
        $this->impression_gateway                   = $impression_gateway;
        $this->impression_log_loading_queue_gateway = $impression_log_loading_queue_gateway;
        $this->unique_daily_view_gateway            = $unique_daily_view_gateway;
    }

    /**
     * @param string $file_name
     * @return bool
     * @throws PithException
     */
    public function isImpressionLogFileQueuedForImport(string $file_name): bool
    {
        // Get if the file is in the queue
        $is_queued_for_import = $this->impression_log_loading_queue_gateway->isImpressionLogFileQueuedForImport($file_name);

        // Return ture if the file is in the queue, else return false if the file is not in the queue
        return $is_queued_for_import;
    }

    /**
     * @throws PithException
     */
    public function addImpressionLogFileToQueueForImport(string $file_name): int
    {
        // Add to queue
        $queue_id = $this->impression_log_loading_queue_gateway->addImpressionLogFileToQueueForImport($file_name);

        // Return the queue_id as int
        return $queue_id;
    }

    /**
     * @return array
     * @throws PithException
     */
    public function getOldestQueuedImpressionLog():array
    {
        // Get oldest row from queue
        $queued_row = $this->impression_log_loading_queue_gateway->getOldestQueuedImpressionLog();

        return $queued_row;
    }

    /**
     * @throws PithException
     */
    public function markQueuedImpressionLogFileAsNotFound(int $queue_item_id): bool
    {
        $did_update = $this->impression_log_loading_queue_gateway->markQueuedImpressionLogFileAsNotFound($queue_item_id);

        return $did_update;
    }

    /**
     * @throws PithException
     */
    public function markQueuedImpressionLogFileAsStartedLoading(int $queue_item_id): bool
    {
        $did_update = $this->impression_log_loading_queue_gateway->markQueuedImpressionLogFileAsStartedLoading($queue_item_id);

        return $did_update;
    }


    /**
     * @throws PithException
     */
    public function markQueuedImpressionLogFileAsDoneLoading(int $queue_item_id): bool
    {
        $did_update = $this->impression_log_loading_queue_gateway->markQueuedImpressionLogFileAsDoneLoading($queue_item_id);

        return $did_update;
    }


    /**
     * @throws PithException
     */
    public function markQueuedImpressionLogFileAsDeletedAfterLoading(int $queue_item_id): bool
    {
        $did_update = $this->impression_log_loading_queue_gateway->markQueuedImpressionLogFileAsDeletedAfterLoading($queue_item_id);

        return $did_update;
    }

    /**
     * @throws PithException
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
        $did_insert = $this->impression_gateway->insertImpression(
            $impression_datetime,
            $impression_http_method,
            $impression_uri,
            $impression_port_as_int,
            $impression_access_level,
            $was_allowed_01,
            $impression_remote_ip_address,
            $impression_session_id,
            $was_logged_user_01,
            $impression_user_id_int,
            $impression_user_agent_string,
            $ch_ua,
            $ch_ua_platform,
            $ch_ua_platform_version,
            $ch_ua_mobile,
            $ch_ua_model,
            $ch_ua_architecture,
            $ch_ua_bitness,
            $client_accept_language_string,
            $referer_string,
            $ch_downlink,
            $ch_viewport_width,
            $ch_prefers_color_scheme
            );

        return $did_insert;
    }

    /**
     * @return array
     * @throws PithException
     */
    public function getNextQueuedImpressionLogMarkedAsLoadedButNotDeletedYet(): array
    {
        $queue_row = $this->impression_log_loading_queue_gateway->getNextQueuedImpressionLogMarkedAsLoadedButNotDeletedYet();

        return $queue_row;
    }

    /**
     * @return array
     * @throws PithException
     */
    public function getNextQueuedImpressionLogToImport():array
    {
        // Get oldest row from queue
        $queued_row = $this->impression_log_loading_queue_gateway->getNextQueuedImpressionLogToImport();

        return $queued_row;
    }

    /**
     * @return int
     * @throws PithException
     */
    public function clearItemsFromTheImpressionLogLoadingQueueThatAreNoLongerNeeded(): int
    {
        $number_of_rows_deleted = $this->impression_log_loading_queue_gateway->deleteItemsFromTheImpressionLogLoadingQueueThatAreNoLongerNeeded();

        return $number_of_rows_deleted;
    }

    /**
     * @return array
     * @throws PithException
     */
    public function findDistinctImpressionsWithoutUniqueDailyViews(): array
    {
        $results = $this->impression_gateway->findDistinctImpressionsWithoutUniqueDailyViews();

        return $results;
    }

    /**
     * @throws PithException
     */
    public function insertNewUniqueDailyView(array $distinct_impression): int
    {
        $inserted_id = $this->unique_daily_view_gateway->insertNewUniqueDailyView($distinct_impression);

        return $inserted_id;
    }


}