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
    private ImpressionLogLoadingQueueGateway $impression_log_loading_queue_gateway;

    public function __construct(ImpressionLogLoadingQueueGateway $impression_log_loading_queue_gateway)
    {
        // Set object dependencies:
        $this->impression_log_loading_queue_gateway = $impression_log_loading_queue_gateway;
    }

    /**
     * @param string $file_name
     * @return bool
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


}