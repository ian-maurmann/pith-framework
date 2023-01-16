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
 * Pith Info
 * ---------
 */


declare(strict_types=1);


namespace Pith\Framework;


/**
 * Class PithInfo
 * @package Pith\Framework
 */
class PithInfo
{
    private PithMeta $meta;

    public function __construct(PithMeta $meta)
    {
        $this->meta = $meta;
    }

    /**
     * @return string
     */
    public function getVersionSlug(): string
    {
        return $this->meta->framework_name . ' ' . $this->meta->real_version . ' (semver ' . $this->meta->semver_version . ') - ' . $this->meta->release_name;
    }
}