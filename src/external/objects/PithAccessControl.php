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
 * Pith Access Control
 * --------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpPropertyOnlyWrittenInspection      - Ignore.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Variable names with underscores are ok.
 */


declare(strict_types=1);


namespace Pith\Framework;


use Pith\Framework\Internal\PithAppReferenceTrait;

/**
 * Class PithAccessControl
 * @package Pith\Framework
 */
class PithAccessControl
{
    use PithAppReferenceTrait;

    private $access_levels;



    public function __construct()
    {
        // Initial vars:
        $this->access_levels = [];
    }



    /**
     * @param $access_level_name
     * @return bool
     */
    public function isAllowedToAccess($access_level_name): bool
    {
        $is_allowed = false;
        $access_level_object = $this->getAccessLevel($access_level_name);

        if (is_object($access_level_object)) {
            $is_allowed = $access_level_object->isAllowedToAccess();
        }

        return $is_allowed;
    }



    /**
     * @param $access_level_name
     * @return object|bool
     */
    public function getAccessLevel($access_level_name)
    {
        $access_level = false;

        if ($access_level_name === 'none') {
            // TODO
        } elseif ($access_level_name === 'world') {
            $access_level = $this->app->container->get('\\Pith\\InternalAccessLevels\\PithWorldAccessLevel');
        }


        if (is_object($access_level)) {
            $access_level->setApp($this->app);
        }

        return $access_level;
    }
}