<?php

# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

/**
 * Pith Meta
 * ---------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework;

/**
 * Class PithMeta
 * @package Pith\Framework
 */
class PithMeta
{
    public $framework_name = 'Pith Framework';
    public $copyright      = 'Copyright (c) 2008-2022 Ian K Maurmann';
    public $license        = 'Mozilla Public License, v. 2.0';
    public $release_status = 'Alpha';
    public $release_name   = 'Alpha 34';
    public $real_version   = '0.8.1.0';
    public $semver_version = '0.20.0';
}