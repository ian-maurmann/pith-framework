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
 * Test-Quote Gateway
 * ------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable name are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\TestQuotes;

use Pith\Framework\PithPostgresWrapper;
use Pith\Framework\PithException;

/**
 * Class TestQuoteGateway
 * @package Pith\Framework\SharedInfrastructure\Model\TestQuotes
 */
class TestQuoteGateway
{
    private PithPostgresWrapper $database;

    public function __construct(PithPostgresWrapper $database)
    {
        $this->database = $database;
    }

    /**
     * @return array
     * @throws PithException
     */
    public function getQuotes(): array
    {
        // Query
        $sql = 'SELECT * FROM pith_test_quotes WHERE quote_id < 100';

        // Execute
        $results = $this->database->query($sql);

        // Check results
        $has_results = is_array($results) && (count($results) > 0);

        // Return the results or an empty array
        return $has_results ? $results : [];
    }
}