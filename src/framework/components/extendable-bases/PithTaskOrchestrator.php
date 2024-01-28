<?php
# ===================================================================
# Copyright (c) 2008-2024 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

/**
 * Pith Task Orchestrator (extend)
 * -------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework;

/**
 * Class PithTaskOrchestrator
 * @package Pith\Framework
 */
class PithTaskOrchestrator
{
    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection - Ignore for now. */
    public function orchestrate(bool $skip_heavy = false): array
    {
        return [
            'did_run_task'       => false,
            'ran_task_name'      => '',
            'is_heavy'           => false,
            'skipped_task_names' => [],
        ];
    }
}