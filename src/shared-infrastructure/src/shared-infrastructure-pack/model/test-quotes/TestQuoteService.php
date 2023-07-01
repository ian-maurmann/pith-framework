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
 * Test-Quote Service
 * ------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpPropertyNamingConventionInspection - Long property names are ok.
 * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Model\TestQuotes;


use Exception;
use Pith\Framework\PithException;

/**
 * Class TestQuoteService
 * @package Pith\Framework\SharedInfrastructure\Model\TestQuotes
 */
class TestQuoteService
{
    private TestQuoteGateway $test_quote_gateway;

    public function __construct(TestQuoteGateway $test_quote_gateway)
    {
        // Object Dependencies
        $this->test_quote_gateway = $test_quote_gateway;
    }

    /**
     * @return array
     */
    public function getQuotes(): array
    {
        // Default to empty array
        $quotes = [];

        try {
            $quotes = $this->test_quote_gateway->getQuotes();
        } catch (PithException $e) {
            // TODO - Log exception
        }

        return $quotes;
    }
}