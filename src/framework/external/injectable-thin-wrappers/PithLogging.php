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
 * Pith Logging - Thin wrapper to pass the Log around
 * --------------------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok here.
 */


declare(strict_types=1);

namespace Pith\Framework;


use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class PithLogging
 * @package Pith\Framework
 */
class PithLogging
{
    public Logger $log;

    public function __construct()
    {
        // Setup the Monolog logger
        // -------------------------------------------------------------
        $monolog = new Logger('Pith');
        $monolog_stream = new StreamHandler('php://stdout', Logger::DEBUG);
        $monolog_format = new LineFormatter(
            null, // Format of message in log, default [%datetime%] %channel%.%level_name%: %message% %context% %extra%\n
            'D M d H:i:s Y', // Datetime format // 'Y-m-d H:i:s'
            true, // allowInlineLineBreaks option, default false
            true  // ignoreEmptyContextAndExtra option, default false
        );
        $monolog_stream->setFormatter($monolog_format);
        $monolog->pushHandler($monolog_stream);
        // -------------------------------------------------------------

        $this->log = $monolog;
    }
}