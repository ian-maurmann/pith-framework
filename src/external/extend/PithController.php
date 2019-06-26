<?php
# ===================================================================
# Copyright (c) 2009-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Controller (extend)
// ------------------------


declare(strict_types=1);


namespace Pith\Framework;


class PithController
{
    protected $app;
    protected $inject;

    function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->resetInject();
    }

    public function whereAmI()
    {
        return 'Pith Controller instance';
    }

    public function getInject()
    {
        return $this->inject;
    }

    public function resetInject()
    {
        $this->inject = (object)[];
    }
}