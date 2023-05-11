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
 * Pith Access Control
 * --------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpPropertyOnlyWrittenInspection      - Ignore.
 * @noinspection PhpMethodNamingConventionInspection   - Long method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Variable names with underscores are ok.
 */


declare(strict_types=1);


namespace Pith\Framework;


use Pith\Framework\Internal\PithAppReferenceTrait;

/**
 * Class PithAccessControl
 * @package Pith\Framework
 */
class PithAccessControl
{
    private PithDependencyInjection $dependency_injection;

    public function __construct(PithDependencyInjection $dependency_injection)
    {
        // Objects
        $this->dependency_injection = $dependency_injection;
    }


    /**
     * @param  $access_level_name
     * @return bool
     * @throws PithException
     */
    public function isAllowedToAccess($access_level_name): bool
    {
        $is_allowed = false;
        $access_level_object = $this->getAccessLevel($access_level_name);

        if (is_object($access_level_object)) {
            $is_allowed = $access_level_object->isAllowedToAccess();
        }

        return $is_allowed;
    }


    /**
     * @param  string $access_level_string - Either a pre-defined access level name, or else an object namespace.
     * @return object|bool
     * @throws PithException
     *
     * @noinspection PhpUnusedLocalVariableInspection     - For readability.
     * @noinspection PhpFullyQualifiedNameUsageInspection - Ignore here.
     */
    public function getAccessLevel(string $access_level_string): object|false
    {
        $access_level = false;


        // Try to load the access level
        try {
            // 'none' --- No access
            if ($access_level_string === 'none') {
                $access_level = false;
            }

            // 'world' --- Full access for anyone
            elseif ($access_level_string === 'world') {
                $access_level = $this->dependency_injection->container->get('Pith\\Framework\\Internal\\WorldAccessLevel');
            }

            // Else treat the string as an object namespace
            else{
                $access_level = $this->dependency_injection->container->get($access_level_string);
            }

        }

        
        // On failure to load Access Level object
        catch (\DI\DependencyException $exception) {
            throw new PithException(
                'Pith Framework Exception 4028: The Access Control could not load the Access Level due to a Dependency Exception. The container encountered a \DI\DependencyException exception. Message: ' . $exception->getMessage(),
                4028,
                $exception
            );
        }
        catch (\DI\NotFoundException $exception) {
            throw new PithException(
                'Pith Framework Exception 4027: The Access Control could not find the Access Level. The container encountered a \DI\NotFoundException exception. Message: ' . $exception->getMessage(),
                4027,
                $exception
            );
        }


        // After load
        if (is_object($access_level)) {
            // Get App
            $app = $this->dependency_injection->container->get('\\Pith\\Framework\\PithApp');

            // Set app reference
            $access_level->setAppReference($app);
        }
        else{
            $access_level = false;
        }

        // Return the Access Level Object, else return false
        return $access_level;
    }

    /**
     * @throws PithException
     */
    public function checkAccess($given_access_level_name)
    {
        // Check access
        $is_allowed = $this->isAllowedToAccess($given_access_level_name);

        if(!$is_allowed){
            // If not logged in:
            // TODO - Throw exception - Handle it and then - Deny & show the login page

            // If logged in:
            // TODO - Throw exception - Handle it and then - Deny & show the access denied page

            throw new PithException(
                'Pith Framework Exception 4007: Workflow element access denied.',
                4007
            );
        }
    }
}