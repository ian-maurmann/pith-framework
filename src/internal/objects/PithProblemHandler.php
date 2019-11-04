<?php
# ===================================================================
# Copyright (c) 2008-2019 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Problem Handler
// --------------------


declare(strict_types=1);

namespace Pith\Framework\Internal;

class PithProblemHandler
{
    private $app;
    private $string_utility;
    private $problem_list;


    function __construct(PithStringUtility $string_utility, PithProblemList $problem_list)
    {
        $this->string_utility = $string_utility;
        $this->problem_list   = $problem_list;
    }

    public function init($app){
        $this->app = $app;
    }


    public function whereAmI()
    {
        return "Pith Problem Handler";
    }

    public function handleProblem($problem_name, ...$info)
    {
        $problem               = $this->problem_list->getProblemByName($problem_name);
        $status                = (string) $problem['status'];
        $error_level           = (string) $problem['level'];
        $error_code            = (string) $problem['code'];
        $error_message         = (string) $problem['message'];
        $error_detail_template = (string) $problem['detail'];
        $error_detail          = vsprintf($error_detail_template, $info);

        $log_message = $error_code . "\n"
            . '--- ' . $error_message . "\n"
            . '--- ' . $error_detail;

        $this->app->log->log($error_level, $log_message);


        // Redirect
        if($status === '404'){
            $this->redirect404();
        }
        elseif($status === '501'){
            $this->redirect501();
        }

    }



    public function redirect404()
    {
        // header('HTTP/1.1 404 Not Found');
        // header('Refresh:0; url=' . $this->app->config->profile->error_404_url);
        // exit;

        header('Location: ' . $this->app->config->profile->error_404_url);
        exit;
    }




    public function redirect501()
    {
        header('HTTP/1.1 501 Not Implemented');
        header('Refresh:0; url=' . $this->app->config->profile->error_501_url);
        exit;
    }







}