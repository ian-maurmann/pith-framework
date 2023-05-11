<?php
# ===================================================================
# Copyright (c) 2008-2023 Ian K Maurmann. The Pith Framework is
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
    private string $transaction_problems;




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
        $this->did_connect          = false;
        $this->dsn                  = '';
        $this->connection_problems  = '';
        $this->query_problems       = '';
        $this->last_query           = '';
        $this->transaction_problems = '';

        // Default options
        $this->options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        // Initialize the database's Username/Password/DSN from env constants
        $this->primeDatabase();
    }


    public function primeDatabase()
    {
        $this->setDsn(PITH_APP_DATABASE_DSN);
        $this->setDbUserAndPassword(PITH_APP_DATABASE_USER_USERNAME, PITH_APP_DATABASE_USER_PASSWORD);
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
        // Connect if not connected
        $this->connectOnce();

        $results = false;
        $number_of_args = func_num_args();

        // ===============================================================
        // For when we need to measure query performance

        // Before:
        // $start_hires_time        = hrtime(true);
        // $start_memory            = memory_get_usage(false);

        // After
        // $end_hires_time          = hrtime(true);
        // $end_memory              = memory_get_usage(false);
        // $hires_time_elapsed      = $end_hires_time - $start_hires_time;
        // $memory_jump_after_query = $end_memory - $start_memory;
        // ===============================================================

        // Query without parameters
        if ($number_of_args === 1) {
            try {
                $sql = func_get_arg(0);
                $this->last_query = $sql;
                $this->results_handle = $this->pdo->query($sql);
                $results = $this->results_handle->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $exception) {
                $this->query_problems .= 'Query error: ' . $exception->getCode() . ' - ' . $exception->getMessage() . '. ';

                throw new PithException(
                    'Pith Framework Exception 6002: The database wrapper encountered a PDOException exception while running query. ' . $this->query_problems,
                    6002,
                    $exception
                );
            }
        }

        // Query with bound parameters
        elseif ($number_of_args > 1) {
            try {
                $sql = func_get_arg(0);
                $args = func_get_args();
                $param_args = array_splice($args, 1);
                $query_params = $this->helper->flattenArgs($param_args);

                $this->last_query = $sql;
                $this->statement_handle = $this->pdo->prepare($sql);
                $this->statement_handle->execute($query_params);
                $results = $this->statement_handle->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $exception) {
                $this->query_problems .= 'Query error: ' . $exception->getCode() . ' - ' . $exception->getMessage() . '. ';

                throw new PithException(
                    'Pith Framework Exception 6003: The database wrapper encountered a PDOException exception while running prepared query. ' . $this->query_problems,
                    6003,
                    $exception
                );
            }
        }

        // Query with no args
        elseif (!$number_of_args) {
            // TODO - Maybe something to run queries from query object ?

            $this->query_problems .= 'Query problem: No query to run. ';

            throw new PithException(
                'Pith Framework Exception 6004: The database wrapper has no arguments for query. ' . $this->query_problems,
                6004
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
        $error                = error_get_last();
        $connection_problems  = strlen($this->connection_problems) ? $this->connection_problems : 'none';
        $transaction_problems = strlen($this->transaction_problems) ? $this->transaction_problems : 'none';
        $query_problems       = strlen($this->query_problems) ? $this->query_problems : 'none';
        $other_problems       = 'none';

        if (is_array($error)) {
            $error_type    = $this->error_utility->getErrorTypeByValue($error['type']);
            $error_message = $error['message'];
            $error_file    = $error['file'];
            $error_line    = $error['line'];

            $other_problems = $error_type . ': "' . $error_message . '", in file "' . $error_file . '" on line ' . $error_line . '.';
        }

        $problems = [
            'connection'  => $connection_problems,
            'transaction' => $transaction_problems,
            'query'       => $query_problems,
            'other'       => $other_problems,
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
        $problems             = $this->listPossibleProblems();
        $connection_problems  = $problems['connection'];
        $transaction_problems = $problems['transaction'];
        $query_problems       = $problems['query'];
        $other_problems       = $problems['other'];
        $did_connect_yn       = ($this->did_connect) ? 'yes' : 'no';
        $status               = $this->getStatus();
        $last_query           = $this->last_query;


        $html = $this->helper->generateHtmlTableForDebugging($connection_problems, $transaction_problems, $query_problems, $other_problems, $did_connect_yn, $status, $last_query);

        return $html;
    }



    /**
     * @return bool
     * @throws PithException
     *
     * @noinspection PhpExpressionAlwaysConstantInspection - Ignore for now, Function should return true if no exceptions.
     * @noinspection PhpUnused                             - Ignore unused for now.
     */
    public function startTransaction(): bool
    {
        // Connect if not connected
        $this->connectOnce();

        // Try to start transaction
        try {
            $did_transaction_start = $this->pdo->beginTransaction();
        } catch (PDOException $exception) {
            $this->transaction_problems .= 'Transaction exception on start Transaction: ' . $exception->getCode() . ' - ' . $exception->getMessage() . '. ';

            throw new PithException(
                'Pith Framework Exception 6005: The database wrapper encountered a PDOException exception while beginning a new transaction. (This usually happens when there is already a transaction started or if the driver does not support transactions) ' . $this->transaction_problems,
                6005,
                $exception
            );
        }

        // Handle when transaction failed to start, but didn't encounter any PDO Exceptions
        if(!$did_transaction_start){
            $this->transaction_problems .= 'Transaction failed to start.';

            throw new PithException(
                'Pith Framework Exception 6006: The database wrapper was unable to start a transaction.' . $this->transaction_problems,
                6006,
            );
        }

        // Return true if the transaction started
        return $did_transaction_start;
    }



    /**
     * @return bool
     * @throws PithException
     *
     * @noinspection PhpExpressionAlwaysConstantInspection - Ignore for now, Function should return true if no exceptions.
     * @noinspection PhpUnused                             - Ignore unused for now.
     */
    public function commitTransaction(): bool
    {
        // Try to commit transaction
        try {
            $did_commit = $this->pdo->commit();
        } catch (PDOException $exception) {
            $this->transaction_problems .= 'Transaction exception on commit Transaction: ' . $exception->getCode() . ' - ' . $exception->getMessage() . '. ';

            throw new PithException(
                'Pith Framework Exception 6007: The database wrapper encountered a PDOException exception during a transaction commit. (This usually happens when there is no active transactions for some reason, such as an earlier database definition language (DDL) statement happening in the same transaction, or because of an earlier Rollback) ' . $this->transaction_problems,
                6007,
                $exception
            );
        }

        // Handle when transaction failed to commit, but didn't encounter any PDO Exceptions
        if(!$did_commit){
            $this->transaction_problems .= 'Transaction failed to commit.';

            throw new PithException(
                'Pith Framework Exception 6008: The database wrapper was unable to commit a transaction.' . $this->transaction_problems,
                6008,
            );
        }

        // Return true if did commit
        return $did_commit;
    }



    /**
     * @return bool
     * @throws PithException
     *
     * @noinspection PhpExpressionAlwaysConstantInspection - Ignore for now, Function should return true if no exceptions.
     * @noinspection PhpUnused                             - Ignore unused for now.
     */
    public function rollbackTransaction(): bool
    {
        // Try to roll back transaction
        try {
            $did_rollback = $this->pdo->rollBack();
        } catch (PDOException $exception) {
            $this->transaction_problems .= 'Transaction exception on rollback Transaction: ' . $exception->getCode() . ' - ' . $exception->getMessage() . '. ';

            throw new PithException(
                'Pith Framework Exception 6009: The database wrapper encountered a PDOException exception during a transaction rollback. (This usually happens when there is no active transactions for some reason, such as an earlier database definition language (DDL) statement happening in the same transaction, or because of an earlier Commit to the Transaction) ' . $this->transaction_problems,
                6009,
                $exception
            );
        }

        // Handle when transaction failed to rollback, but didn't encounter any PDO Exceptions
        if(!$did_rollback){
            $this->transaction_problems .= 'Transaction failed to roll back.';

            throw new PithException(
                'Pith Framework Exception 6010: The database wrapper was unable to roll back a transaction.' . $this->transaction_problems,
                6010,
            );
        }

        // Return true if did rollback
        return $did_rollback;
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