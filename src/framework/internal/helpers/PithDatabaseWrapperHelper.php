<?php
# ===================================================================
# Copyright (c) 2008-2024 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================


/**
 * Pith Database Wrapper Helper
 * ----------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpTooManyParametersInspection        - Methods having a large number of parameters are ok.
 */

declare(strict_types=1);


namespace Pith\Framework\Internal;


/**
 * Class PithDatabaseWrapperHelper
 * @package Pith\Framework\Internal
 */
class PithDatabaseWrapperHelper
{
    public function __construct()
    {
        // Nothing for now
    }



    /**
     * @param $args
     * @return array
     */
    public function flattenArgs($args): array
    {
        $flat_args = [];

        foreach ($args as $arg) {
            if (is_array($arg)) {
                foreach ($arg as $arg_item) {
                    $flat_args[] = $arg_item;
                }
            } else {
                $flat_args[] = $arg;
            }
        }

        return $flat_args;
    }


    /**
     * @param $connection_problems
     * @param $transaction_problems
     * @param $query_problems
     * @param $other_problems
     * @param $did_connect_yn
     * @param $status
     * @param $last_query
     * @return string
     *
     * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
     */
    public function generateHtmlTableForDebugging($connection_problems, $transaction_problems, $query_problems, $other_problems, $did_connect_yn, $status, $last_query): string
    {
        $htmlsafe_connection_problems  = htmlentities($connection_problems);
        $htmlsafe_transaction_problems = htmlentities($transaction_problems);
        $htmlsafe_query_problems       = htmlentities($query_problems);
        $htmlsafe_other_problems       = htmlentities($other_problems);
        $htmlsafe_did_connect_yn       = htmlentities($did_connect_yn);
        $htmlsafe_status               = htmlentities($status);
        $htmlsafe_last_query           = htmlentities($last_query);

        $html = '<table data-table-type="database-debug">
                    <tbody>
                        <tr>
                            <th>Connection Problems</th>
                            <td>' . $htmlsafe_connection_problems . '</td>
                        </tr>
                        <tr>
                            <th>Did connect?</th>
                            <td>' . $htmlsafe_did_connect_yn . '</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>' . $htmlsafe_status . '</td>
                        </tr>
                        <tr>
                            <th>Transaction Problems</th>
                            <td>' . $htmlsafe_transaction_problems . '</td>
                        </tr>
                        <tr>
                            <th>Last Query SQL</th>
                            <td>' . $htmlsafe_last_query . '</td>
                        </tr>
                        <tr>
                            <th>Query Problems</th>
                            <td>' . $htmlsafe_query_problems . '</td>
                        </tr>
                        <tr>
                            <th>Other Problems</th>
                            <td>' . $htmlsafe_other_problems . '</td>
                        </tr>
                    </tbody>
                 </table>';

        return $html;
    }


}