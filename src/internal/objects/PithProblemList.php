<?php
# ===================================================================
# Copyright (c) 2009-2019 Ian K Maurmann. The Pith Framework is
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
        // 404 - Redirect to the 401 error page
        // 501 - Redirect to the 501 error page
        //=====================================

        $problems = [

            'Pith_Provisional_Notice_B5_000' => [
                'code'    => 'Pith_Provisional_Notice_B5_000',
                'message' => 'App Route not found.',
                'detail'  => 'Pith Framework: The Router could not find any route for Url: "%s".',
                'level'   => 'notice',
                'status'  => '404',
            ],

            'Pith_Provisional_Error_B5_001' => [
                'code'    => 'Pith_Provisional_Error_B5_001',
                'message' => 'Module not found.',
                'detail'  => 'Pith Framework: When the Router ran the Route "%s", the Container could not find the Module "%s" being autoloaded.',
                'level'   => 'error',
                'status'  => '501',
            ],

            'Pith_Provisional_Error_B5_002' => [
                'code'    => 'Pith_Provisional_Notice_B5_002',
                'message' => 'Module Route not found.',
                'detail'  => 'Pith Framework: The Router could not find any route named "%s" inside the Module "%s".',
                'level'   => 'error',
                'status'  => '501',
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