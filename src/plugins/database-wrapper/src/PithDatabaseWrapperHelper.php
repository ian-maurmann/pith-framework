<?php
# ===================================================================
# Copyright (c) 2008-2020 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Pith Database Wrapper Helper
// ----------------------------

namespace Pith\DatabaseWrapper;


class PithDatabaseWrapperHelper
{

    function __construct()
    {
        // Nothing for now
    }

    public function flattenArgs($args)
    {
        $flat_args = [];

        foreach($args as $arg){
            if(is_array($arg)){
                foreach($arg as $arg_item){
                    $flat_args[] = $arg_item;
                }
            }
            else{
                $flat_args[] = $arg;
            }
        }

        return $flat_args;
    }


    public function generateHtmlTableForDebugging($connection_problems, $query_problems, $other_problems, $did_connect_yn, $status, $last_query)
    {
        $htmlsafe_connection_problems = htmlentities($connection_problems);
        $htmlsafe_query_problems      = htmlentities($query_problems);
        $htmlsafe_other_problems      = htmlentities($other_problems);
        $htmlsafe_did_connect_yn      = htmlentities($did_connect_yn);
        $htmlsafe_status              = htmlentities($status);
        $htmlsafe_last_query          = htmlentities($last_query);

        $html = '<table>
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Connection Problems</td>
                            <td>' . $htmlsafe_connection_problems . '</td>
                        </tr>
                        <tr>
                            <td>Did connect?</td>
                            <td>' . $htmlsafe_did_connect_yn . '</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>' . $htmlsafe_status . '</td>
                        </tr>
                        <tr>
                            <td>Last Query SQL</td>
                            <td>' . $htmlsafe_last_query . '</td>
                        </tr>
                        <tr>
                            <td>Query Problems</td>
                            <td>' . $htmlsafe_query_problems . '</td>
                        </tr>
                        <tr>
                            <td>Other Problems</td>
                            <td>' . $htmlsafe_other_problems . '</td>
                        </tr>
                    </tbody>
                 </table>';

        return $html;
    }


}