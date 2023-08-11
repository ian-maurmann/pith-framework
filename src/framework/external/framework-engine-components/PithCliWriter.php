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
 * Pith CLI Writer
 * ---------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework;


/**
 * Class PithCliWriter
 * @package Pith\Framework
 */
class PithCliWriter
{
    private array $writes;

    public function __construct()
    {
        // Set object dependencies:
        // Do nothing for now.

        // Set defaults:
        $this->writes = [];
    }

    public function write(...$args): void
    {
        foreach ($args as $arg) {
            if (is_object($arg) || is_array($arg) || is_resource($arg)) {
                $output = print_r($arg, true);
            } else {
                $output = (string) $arg;
            }

            // Save output for later
            $this->writes[] = $output;

            // Write to CLI
            fwrite(STDOUT, $output);
        }
    }

    /**
     * Send a log message to the STDOUT stream.
     *
     * @param array<int, mixed> $args
     * @return void
     */
    public function writeLine(...$args): void
    {
        foreach ($args as $arg) {
            if (is_object($arg) || is_array($arg) || is_resource($arg)) {
                $output = print_r($arg, true);
            } else {
                $output = (string) $arg;
            }

            // Save output for later
            $this->writes[] = $output;

            // Write to CLI
            fwrite(STDOUT, $output . "\n");
        }
    }

    /**
     * @return array
     */
    public function getWrites(): array
    {
        return $this->writes;
    }
}