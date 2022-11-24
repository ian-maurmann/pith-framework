<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);


// Pith Database Wrapper for MySQL using PDO
// -----------------------------------------

namespace Pith\DatabaseWrapper;

use Pith\InternalUtilities\PithErrorUtility;
use Pith\InternalUtilities\PithArrayUtility;

class PithDatabaseWrapper
{
    private $helper;
    private $array_utility;
    private $error_utility;
    private $dsn;
    private $options;
    private $did_connect;
    private $pdo;
    private $db_user_username;
    private $db_user_password;
    private $connection_problems;
    private $query_problems;
    private $results_handle;
    private $statement_handle;
    private $last_query;

    function __construct(PithDatabaseWrapperHelper $helper, PithArrayUtility $array_utility, PithErrorUtility $error_utility)
    {
        // Objects
        $this->helper        = $helper;
        $this->array_utility = $array_utility;
        $this->error_utility = $error_utility;

        // Initial vars:
        $this->did_connect = false;
        $this->dsn = '';
        $this->connection_problems = '';
        $this->query_problems = '';
        $this->last_query = '';

        // Default options
        $this->options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }


    public function setDsn($dsn)
    {
        $this->dsn = $dsn;
    }


    public function setOptions($options)
    {
        $this->options = $options;
    }


    public function setDbUserAndPassword($db_user_username, $db_user_password)
    {
        $this->db_user_username = $db_user_username;
        $this->db_user_password = $db_user_password;
    }


    public function getStatus()
    {
        $status = 'Not Connected';

        if($this->did_connect){
            $status = 'Connected to ' . $this->pdo->getAttribute(\PDO::ATTR_CONNECTION_STATUS);
        }

        return $status;
    }


    public function connect()
    {
        $did_connect = true;
        try{
            $this->pdo = new \PDO($this->dsn, $this->db_user_username, $this->db_user_password, $this->options);
        }
        catch(\PDOException $exception){
            $did_connect = false;
            $this->connection_problems .= 'Connection failed: ' . $exception->getMessage() . '. ';
        }
        $this->did_connect = $did_connect;

        return $did_connect;
    }


    public function connectOnce()
    {
        if(!$this->did_connect){
            $this->connect();
        }
        return $this->did_connect;
    }


    public function whereAmI()
    {
        return 'Pith Database Wrapper';
    }

    public function query()
    {
        $results        = false;
        $number_of_args = func_num_args();

        try{
            if($number_of_args === 1) {
                $sql = func_get_arg(0);
                $this->last_query = $sql;
                $this->results_handle = $this->pdo->query($sql);
                $results = $this->results_handle->fetchAll(\PDO::FETCH_ASSOC);
            }
            elseif($number_of_args > 1){
                $sql          = func_get_arg(0);
                $args         = func_get_args();
                $param_args   = array_splice($args, 1);
                $query_params = $this->helper->flattenArgs($param_args);

                $this->last_query = $sql;
                $this->statement_handle = $this->pdo->prepare($sql);
                $this->statement_handle->execute($query_params);
                $results = $this->statement_handle->fetchAll(\PDO::FETCH_ASSOC);
            }
            elseif(!$number_of_args){
                // TODO
                $this->query_problems .= 'Query problem: No query to run. ';
            }
        }
        catch(\PDOException $exception){
            $this->query_problems .= 'Query error: ' . $exception->getCode() . ' - ' . $exception->getMessage() . '. ';
        }

        return $results;
    }


    private function listPossibleProblems()
    {
        $error               = error_get_last();
        $connection_problems = strlen($this->connection_problems) ? $this->connection_problems : 'none';
        $query_problems      = strlen($this->query_problems) ? $this->query_problems : 'none';
        $other_problems      = 'none';

        if (is_array($error)){
            $error_type    = $this->error_utility->getErrorTypeByValue($error['type']);
            $error_message = $error['message'];
            $error_file    = $error['file'];
            $error_line    = $error['line'];

            $other_problems = $error_type . ': "' . $error_message . '", in file "' . $error_file . '" on line ' . $error_line . '.';
        }

        $problems = [
            'connection' => $connection_problems,
            'query'      => $query_problems,
            'other'      => $other_problems,
        ];

        return $problems;
    }


    public function debug()
    {
        $problems            = $this->listPossibleProblems();
        $connection_problems = $problems['connection'];
        $query_problems      = $problems['query'];
        $other_problems      = $problems['other'];
        $did_connect_yn      = ($this->did_connect) ? 'yes' : 'no' ;
        $status              = $this->getStatus();
        $last_query          = $this->last_query;

        $html = $this->helper->generateHtmlTableForDebugging($connection_problems, $query_problems, $other_problems, $did_connect_yn, $status, $last_query);

        return $html;
    }

//    public function run($query_object)
//    {
//        $params      = $this->array_utility->flatten( $query_object->getParams() );
//        $sql         = $query_object->getSql();
//        $is_prepared = (count($params) > 0) ? true : false ;
//
//        if($is_prepared){
//            $results = $this->query($sql, $params);
//        }
//        else{
//            $results = $this->query($sql);
//        }
//
//        return $results;
//    }


}