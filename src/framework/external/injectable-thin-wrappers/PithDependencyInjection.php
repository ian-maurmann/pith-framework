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
 * Pith Dependency Injection - Thin wrapper to pass the PHP-DI object around
 * -------------------------------------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework;

use DI\Container;

/**
 * Class PithDependencyInjection
 * @package Pith\Framework
 */
class PithDependencyInjection
{
    public Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }
}