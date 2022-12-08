<?php
# ===================================================================
# Copyright (c) 2008-2022 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================



/**
 * Pith Database Wrapper for MySQL using PDO
 * -----------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection          - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection       - Property names with underscores are ok.
 * @noinspection PhpMethodNamingConventionInspection         - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection       - Short variable names are ok.
 * @noinspection PhpPrivateFieldCanBeLocalVariableInspection - Keep the results handle and  statement handle as properties.
 * @noinspection PhpArrayShapeAttributeCanBeAddedInspection  - Array shapes aren't set in stone yet.
 */

declare(strict_types=1);

namespace Pith\Framework;

use PDO;
use PDOException;
use PDOStatement;
use Pith\Framework\Internal\PithDatabaseWrapperHelper;
use Pith\Framework\Internal\PithErrorUtility;

/**
 * Class PithDatabaseWrapper
 * @package Pith\Framework
 */
class PithDatabaseWrapper
{
    // Helper
    private PithDatabaseWrapperHelper $helper;

    // Objects
    private PDO              $pdo;
    private PDOStatement     $results_handle;
    private PDOStatement     $statement_handle;
    private PithErrorUtility $error_utility;

    // Properties
    private string $connection_problems;
    private string $database_user_username;
    private string $database_user_password;
    private bool   $did_connect;
    private string $dsn;
    private string $last_query;
    private array  $options;
    private string $query_problems;




    /**
     * PithDatabaseWrapper constructor.
     * @param PithDatabaseWrapperHelper $helper
     * @param PithErrorUtility          $error_utility
     */
    public function __construct(PithDatabaseWrapperHelper $helper, PithErrorUtility $error_utility)
    {
        // Objects
        $this->helper        = $helper;
        $this->error_utility = $error_utility;

        // Initial vars:
        $this->did_connect         = false;
        $this->dsn                 = '';
        $this->connection_problems = '';
        $this->query_problems      = '';
        $this->last_query          = '';

        // Default options
        $this->options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }



    /**
     * @param $dsn
     */
    public function setDsn($dsn)
    {
        $this->dsn = $dsn;
    }



    /**
     * @param $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }



    /**
     * @param $database_user_username
     * @param $database_user_password
     */
    public function setDbUserAndPassword($database_user_username, $database_user_password)
    {
        $this->database_user_username = $database_user_username;
        $this->database_user_password = $database_user_password;
    }



    /**
     * @return string
     */
    public function getStatus(): string
    {
        $status = 'Not Connected';

        if ($this->did_connect) {
            $status = 'Connected to ' . $this->pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS);
        }

        return $status;
    }


    /**
     * @return bool
     * @throws PithException
     *
     * @noinspection PhpUnusedLocalVariableInspection - Ignore, exception breaks flow.
     */
    public function connect(): bool
    {

        try {
            $did_connect = false;
            $this->pdo   = new PDO($this->dsn, $this->database_user_username, $this->database_user_password, $this->options);
            $did_connect = true;
        } catch (PDOException $exception) {

            $this->connection_problems .= 'Connection failed: ' . $exception->getMessage() . '. ';

            throw new PithException(
                'Pith Framework Exception 6001: The database wrapper encountered a PDOException exception when connecting to the database. ' . $this->connection_problems,
                6001,
                $exception
            );
        }
        $this->did_connect = $did_connect;

        return $did_connect;
    }


    /**
     * @return bool
     * @throws PithException
     */
    public function connectOnce(): bool
    {
        if (!$this->did_connect) {
            $this->connect();
        }

        return $this->did_connect;
    }


    /**
     * @return array|false
     * @throws PithException
     */
    public function query(): bool|array
    {
        $this->connectOnce();

        $results = false;
        $number_of_args = func_num_args();

        try {
            if ($number_of_args === 1) {
                $sql = func_get_arg(0);
                $this->last_query = $sql;
                $this->results_handle = $this->pdo->query($sql);
                $results = $this->results_handle->fetchAll(PDO::FETCH_ASSOC);
            } elseif ($number_of_args > 1) {
                $sql = func_get_arg(0);
                $args = func_get_args();
                $param_args = array_splice($args, 1);
                $query_params = $this->helper->flattenArgs($param_args);

                $this->last_query = $sql;
                $this->statement_handle = $this->pdo->prepare($sql);
                $this->statement_handle->execute($query_params);
                $results = $this->statement_handle->fetchAll(PDO::FETCH_ASSOC);
            } elseif (!$number_of_args) {
                // TODO
                $this->query_problems .= 'Query problem: No query to run. ';
            }
        } catch (PDOException $exception) {
            $this->query_problems .= 'Query error: ' . $exception->getCode() . ' - ' . $exception->getMessage() . '. ';

            throw new PithException(
                'Pith Framework Exception 6002: The database wrapper encountered a PDOException exception while running query. ' . $this->query_problems,
                6002,
                $exception
            );
        }

        return $results;
    }



    /**
     * @return array
     *
     * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
     */
    private function listPossibleProblems(): array
    {
        $error               = error_get_last();
        $connection_problems = strlen($this->connection_problems) ? $this->connection_problems : 'none';
        $query_problems      = strlen($this->query_problems) ? $this->query_problems : 'none';
        $other_problems      = 'none';

        if (is_array($error)) {
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



    /**
     * @return string
     *
     * @noinspection PhpUnnecessaryLocalVariableInspection - For readability.
     */
    public function debug(): string
    {
        $problems            = $this->listPossibleProblems();
        $connection_problems = $problems['connection'];
        $query_problems      = $problems['query'];
        $other_problems      = $problems['other'];
        $did_connect_yn      = ($this->did_connect) ? 'yes' : 'no';
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