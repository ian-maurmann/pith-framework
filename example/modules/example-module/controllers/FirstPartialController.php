<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================



// "FirstPartialController"
// ------------------



declare(strict_types=1);


namespace Pith\ExampleModule;


class FirstPartialController extends \Pith\Framework\PithController implements \Pith\Framework\PithControllerInterface
{
    public function access()
    {
        $this->access_level = 'world';
    }

    public function injector($app)
    {
        // Load Objects
    }

    public function action($app, $objects)
    {
        // Set Objects

        // Action Variables
        $p = 'This is my partial';

        // Push to Preparer
        $this->prepare->p = $p;
    }

    public function preparer($app, $prepare)
    {
        $p = $prepare->p;

        $this->view->p = $p;

        $view_adapter = $app->container->get('\\Pith\\PhtmlViewAdapter\\PithPhtmlViewAdapter');
        $this->view_adapter = $view_adapter;
    }
}