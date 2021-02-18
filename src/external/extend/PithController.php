<?php
# ===================================================================
# Copyright (c) 2008-2021 Ian K Maurmann. The Pith Framework is
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
    protected $access_level;
    protected $inject;
    protected $prepare;
    protected $view;
    protected $view_adapter;

    function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->resetAccessLevel();
        $this->resetInject();
        $this->resetPrepare();
        $this->resetView();
    }

    public function whereAmI()
    {
        return 'Pith Controller instance';
    }

    public function getAccessLevel()
    {
        return $this->access_level;
    }

    public function resetAccessLevel()
    {
        $this->access_level = 'none';
    }

    public function getInject()
    {
        return $this->inject;
    }

    public function resetInject()
    {
        $this->inject = (object)[];
    }

    public function getPrepare()
    {
        return $this->prepare;
    }

    public function resetPrepare()
    {
        $this->prepare = (object)[];
    }

    public function getView()
    {
        return $this->view;
    }

    public function resetView()
    {
        $this->view = (object)[];
    }

    public function getViewAdapter()
    {
        return $this->view_adapter;
    }
}