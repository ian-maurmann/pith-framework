<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================



// "Alpha Controller"
// ------------------



declare(strict_types=1);


namespace Pith\BlueSkyExampleModule;


class AlphaController extends \Pith\Framework\PithController implements \Pith\Framework\PithControllerInterface
{
    public function access()
    {
        $this->access_level = 'world';
    }

    public function injector($app)
    {
        // Load Objects
        $this->inject->obj_one   = 'test one';
        $this->inject->obj_two   = 'test two';
        $this->inject->obj_three = 'test three';
    }

    public function action($app, $objects)
    {
        // Set Objects
        $obj_one   = $objects->obj_one;
        $obj_two   = $objects->obj_two;
        $obj_three = $objects->obj_three;


        // Action Variables
        $a = $obj_one;
        $b = $obj_two;
        $c = $obj_three;


        // Debug
        // echo $a;
        // echo $b;
        // echo $c;


        // Push to Preparer
        $this->prepare->a = $a;
        $this->prepare->b = $b;
        $this->prepare->c = $c;
    }

    public function preparer($app, $prepare)
    {
        $a = $prepare->a;
        $b = $prepare->b;
        $c = $prepare->c;

        $this->view->a = $a;
        $this->view->b = $b;
        $this->view->c = $c;

        $view_adapter = $app->container->get('\\Pith\\PhtmlViewAdapter\\PithPhtmlViewAdapter');
        $this->view_adapter = $view_adapter;
    }
}