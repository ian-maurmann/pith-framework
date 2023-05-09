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
 * Pith Preparer (extend)
 * ---------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework;


use Pith\Framework\Internal\PithEscapeUtility;

/**
 * Class PithPreparer
 * @package Pith\Framework
 */
class PithPreparer extends PithWorkflowElement
{
    /**
     * @var string
     */
    public string $element_type = 'preparer';

    public PithEscapeUtility $escape;

    /**
     * @var object
     */
    protected object $prepare;

    /**
     * @var object
     */
    protected object $view;


    /**
     * @param object $prepare_vars_object
     */
    public function provisionPreparer(object $prepare_vars_object)
    {
        $this->prepare = $prepare_vars_object;
        $this->view    = (object)[];
        $this->escape  = $this->app->container->get('\\Pith\\Framework\\Internal\\PithEscapeUtility');
    }

    /**
     * @return object
     */
    public function getVariablesForView(): object
    {
        return $this->view;
    }

    public function runPreparer()
    {
        // Do nothing
    }
}