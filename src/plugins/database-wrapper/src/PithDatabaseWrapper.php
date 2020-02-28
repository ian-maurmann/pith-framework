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


// Pith Database Wrapper for MySQL using PDO
// -----------------------------------------

namespace Pith\DatabaseWrapper;


class PithDatabaseWrapper
{
    private $dsn;
    private $options;
    private $did_connect;
    private $pdo;
    private $db_user_username;
    private $db_user_password;
    private $connection_problems;

    function __construct()
    {
        // Initial vars:

        $this->did_connect = false;

        $this->dsn = '';

        $this->options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->connection_problems = '';
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

}