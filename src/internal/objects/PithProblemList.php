<?php
# ===================================================================
# Copyright (c) 2008-2020 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


// Pith Problem List
// -----------------


declare(strict_types=1);

namespace Pith\Framework\Internal;

class PithProblemList
{
    public function whereAmI()
    {
        return "Pith Problem List";
    }


    public function getList()
    {



        // level :
        /* ===================================================================

        Levels, based on RFC-5424 and PSR-3

        Name             Numerical    Severity
                         Code
        emergency        0            Emergency :  system is unusable
        alert            1            Alert :  action must be taken immediately
        critical         2            Critical :  critical conditions
        error            3            Error :  error conditions
        warning          4            Warning :  warning conditions
        notice           5            Notice :  normal but significant condition
        informational    6            Informational :  informational messages
        debug            7            Debug :  debug-level messages

        =================================================================== */

        // status
        //=====================================
        // 401 - Redirect to the 401 error page and then Login page
        // 403 - Redirect to the 403 error page
        // 404 - Redirect to the 401 error page
        // 501 - Redirect to the 501 error page
        //=====================================

        $problems = [

            // Future Error 101 ?
            'Pith_Provisional_Notice_B5_000' => [
                'code'    => 'Pith_Provisional_Notice_B5_000',
                'message' => 'App Route not found.',
                'detail'  => 'The Router could not find any route for Url: "%s".',
                'level'   => 'notice',
                'status'  => '404',
            ],

            // Future Error 102 ?
            'Pith_Provisional_Error_B5_001' => [
                'code'    => 'Pith_Provisional_Error_B5_001',
                'message' => 'Module not found.',
                'detail'  => 'When the Router ran the Route "%s", the Container could not find the Module "%s" being autoloaded.',
                'level'   => 'error',
                'status'  => '501',
            ],

            // Future Error 103 ?
            'Pith_Provisional_Error_B5_002' => [
                'code'    => 'Pith_Provisional_Notice_B5_002',
                'message' => 'Module Route not found.',
                'detail'  => 'The Router could not find any route named "%s" inside the Module "%s".',
                'level'   => 'error',
                'status'  => '501',
            ],

            // Future Error 201 ?
            'Pith_Provisional_Error_B6_000' => [
                'code'    => 'Pith_Provisional_Error_B6_000',
                'message' => 'Controller not found.',
                'detail'  => 'When the Dispatcher ran the Route "%s", the Container could not find the Controller "%s" being autoloaded.',
                'level'   => 'error',
                'status'  => '501',
            ],

            // Future Error 301 ?
            'Pith_Provisional_Error_C3_000' => [
                'code'    => 'Pith_Provisional_Error_C3_000',
                'message' => 'Guest request was blocked by Access Control.',
                'detail'  => 'When the Dispatcher ran the Route "%s", the Controller "%s" has an access level of "%s" which the Access Control denied the unauthenticated guest from accessing.',
                'level'   => 'info',
                'status'  => '401',
            ],

            // Future Error 302 ?
            'Pith_Provisional_Error_C3_001' => [
                'code'    => 'Pith_Provisional_Error_C3_001',
                'message' => 'User request was blocked by Access Control.',
                'detail'  => 'When the Dispatcher ran the Route "%s", the Controller "%s" has an access level of "%s" which the Access Control denied User "%s" from accessing.',
                'level'   => 'info',
                'status'  => '403',
            ],

        ];

        return $problems;
    }

    public function getProblemByName($given_problem_name){
        $problem_list  = $this->getList();
        $problem_found = null;

        foreach($problem_list as $at_problem_name => $at_problem){
            if( (string) $at_problem_name === (string) $given_problem_name ){
                $problem_found = $at_problem;
                break;
            }
        }

        return $problem_found;
    }
}