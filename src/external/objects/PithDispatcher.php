<?php
# ===================================================================
# Copyright (c) 2009-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Dispatcher
// ---------------


declare(strict_types=1);

namespace Pith\Framework;

use Pith\Framework\Internal\PithStringUtility;
use Pith\Framework\Internal\PithProblemHandler;


class PithDispatcher
{
    private $app;
    private $string_utility;
    private $problem_handler;

    function __construct(PithStringUtility $string_utility, PithProblemHandler $problem_handler)
    {
        $this->string_utility = $string_utility;
        $this->problem_handler = $problem_handler;
    }


    public function init($app)
    {
        $this->app = $app;
    }


    public function whereAmI()
    {
        return 'Pith Dispatcher';
    }



    public function dispatch($route){

        // Start the output buffer
        ob_start();

        echo '<pre><code>';
        var_dump($route);
        echo '</code></pre>';

        // Flush the output buffer
        ob_end_flush();
    }






}



