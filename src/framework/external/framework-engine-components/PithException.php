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
 * Pith Exception
 * --------------
 *
 * @noinspection PhpPureAttributeCanBeAddedInspection - Ignore Pure for now, functions are still being modified, and might not stay pure.
 *
 *
 *
 * Codes:
 *     0xxx - N/A
 *     1xxx - informational (TODO?)
 *     2xxx - N/A
 *     3xxx - redirection (TODO?)
 *     --------------------------
 *
 *
 *     4xxx - Routing Exceptions Recoverable
 *     ---------------------------------
 *     4000 - Recoverable Routing Exception  (Top-Level / Unspecified)
 *     4004 - FastRoute\Dispatcher::NOT_FOUND
 *     4005 - FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
 *     4006 - Route access denied.
 *     4007 - Workflow element access denied.
 *     4008 - Route does not have an Action.
 *     4009 - Route get Action --> Container: NotFoundException.
 *     4010 - Route get Action --> Container: DependencyException.
 *     4011 - Route does not have a Preparer.
 *     4012 - Route get Preparer --> Container: NotFoundException.
 *     4013 - Route get Preparer --> Container: DependencyException.
 *     4014 - Route does not have a View Adapter.
 *     4015 - Route get View Adapter --> Container: NotFoundException.
 *     4016 - Route get View Adapter --> Container: DependencyException.
 *     4017 - Route does not have a Pack.
 *     4018 - Route get Pack --> Container: NotFoundException.
 *     4019 - Route get Pack --> Container: DependencyException.
 *     4020 - Requested Resource outside of Resource folder.
 *     4021 - Resource folder must be a folder.
 *     4022 - Resource file must be a file.
 *     4023 - Requested Resource path includes a dot file.
 *     4024 - Route does not have a View Requisition.
 *     4025 - Route get View Requisition --> Container: NotFoundException.
 *     4026 - Route get View Requisition --> Container: DependencyException.
 *     4027 - Access Control could not load the Access Level --> Container: NotFoundException.
 *     4028 - Access Control could not load the Access Level --> Container: DependencyException.
 *     4029 - Requested Resource is a file type that should not be inside the resource folder.
 *     4030 - Access Control encountered a problem when running the Access Level
 *     4031 - Workflow element access denied for task.
 *
 *
 *     5xxx - Server Exceptions Unrecoverable
 *     --------------------------------------
 *     5000 - Unrecoverable Server Exception (Top-Level / Unspecified)
 *     5001 - Index Front Controller --> Container: NotFoundException.
 *     5002 - Index Front Controller --> Container: DependencyException.
 *     5003 - Router returned empty routing array.
 *     5004 - Loading route --> Container: NotFoundException.
 *     5005 - Loading route --> Container: DependencyException.
 *     5006 - Loading route list --> Container: DependencyException.
 *     5007 - Loading route list --> Container: NotFoundException.
 *     5008 - Index Front Controller - Dependency Injection Wrapper - NotFoundException.
 *     5009 - Index Front Controller - Dependency Injection Wrapper - DependencyException.
 *     5010 - Pith Framework App variable is not a Pith App Object.
 *     5011 - Loading a route list --> Container: NotFoundException.
 *     5012 - Loading a route list --> Container: DependencyException.
 *
 *     6xxx - Database Exceptions Recoverable
 *     --------------------------------------
 *     6000 - Recoverable Database Exception (Top-Level / Unspecified)
 *     6001 - Database Connection Problem. PDOException on connect.
 *     6002 - The database wrapper encountered a PDOException exception while running query
 *     6003 - The database wrapper encountered a PDOException exception while running prepared query.
 *     6004 - The database wrapper has no arguments for query. Query problem: No query to run.
 *     6005 - The database wrapper encountered a PDOException exception while beginning transaction.
 *     6006 - The database wrapper was unable to start transaction.
 *     6007 - The database wrapper encountered a PDOException exception during a transaction commit.
 *     6008 - The database wrapper was unable to commit a transaction.
 *     6009: The database wrapper encountered a PDOException exception during a transaction rollback.
 *     6010: The database wrapper was unable to roll back a transaction.
 *
 *
 *     7xxx - ?
 *     8xxx - ?
 *
 *      9xxx - Task-Specific Exceptions
 *     --------------------------------
 *      9000 - Task-Specific Exception (Top-Level / Unspecified)
 *      9001 - Touchstone file could not be created
 *      9002 - Touchstone file mtime could not be updated
 *
 *
 */


declare(strict_types=1);


namespace Pith\Framework;

use Exception;
use Throwable;


/**
 * Class PithException
 * @package Pith\Framework
 */
class PithException extends Exception
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @link https://php.net/manual/en/exception.construct.php
     * @param string         $message  The Exception message to throw.
     * @param int            $code     [optional] The Exception code.
     * @param null|Throwable $previous [optional] The previous throwable used for the exception chaining.
     */
    public function __construct($message, $code = 0, Throwable $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }


    /**
     * String representation of the exception
     * @link https://php.net/manual/en/exception.tostring.php
     * @return string the string representation of the exception.
     *
     * @noinspection PhpUnnecessaryCurlyVarSyntaxInspection
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}



