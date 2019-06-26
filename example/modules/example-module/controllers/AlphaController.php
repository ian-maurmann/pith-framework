<?php
# ===================================================================
# Copyright (c) 2009-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================



// "Alpha Controller"
// ------------------



declare(strict_types=1);


namespace Pith\ExampleModule;


class AlphaController extends \Pith\Framework\PithController implements \Pith\Framework\PithControllerInterface
{

    function __construct()
    {
        // construct
    }

    public function access($access)
    {
        $access->setControllerAccessLevel('world');
    }

    public function injector($app, $inject)
    {
        $inject->obj_one   = 'test one';
        $inject->obj_two   = 'test two';
        $inject->obj_three = 'test three';

        return $inject;
    }

    public function action($app)
    {
        echo 'Action';
    }

    public function preparer($app)
    {
        echo 'Preparer';
    }
}