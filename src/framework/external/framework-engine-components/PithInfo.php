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
    private PithAbout $about;

    public function __construct(PithAbout $about)
    {
        $this->about = $about;
    }

    /**
     * @return string
     */
    public function getVersionText(): string
    {
        return $this->about->framework_name . ' ' . $this->about->real_version . ' (semver ' . $this->about->semver_version . ') - ' . $this->about->release_name;
    }

    /**
     * @return string
     */
    public function getVersionPlusSemver(): string
    {
        return $this->about->real_version . ' (sv ' . $this->about->semver_version . ')';
    }

    /**
     * @return string
     */
    public function getCopyrightNotice(): string
    {
        return $this->about->copyright;
    }

    /**
     * @return string
     */
    public function getLicenseName(): string
    {
        return $this->about->license;
    }
}