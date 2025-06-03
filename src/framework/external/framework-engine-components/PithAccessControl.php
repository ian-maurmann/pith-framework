<?php
# ===================================================================
# Copyright (c) 2008-2025 Ian K Maurmann. The Pith Framework is
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


use Exception;
//use Pith\Framework\SharedInfrastructure\Model\UserSystem\UserService;
use Pith\Framework\Plugin\UserSystem4\UserService;

/**
 * Class PithAccessControl
 * @package Pith\Framework
 */
class PithAccessControl
{
    private PithAppRetriever        $app_retriever;
    private PithDependencyInjection $dependency_injection;
    private UserService             $user_service;


    public function __construct(PithAppRetriever $app_retriever, PithDependencyInjection $dependency_injection, UserService $user_service)
    {
        // Set object dependencies
        $this->app_retriever        = $app_retriever;
        $this->dependency_injection = $dependency_injection;
        $this->user_service         = $user_service;
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

            // 'dev-ip' --- Only whitelisted dev IPs
            elseif ($access_level_string === 'dev-ip') {
                $access_level = $this->dependency_injection->container->get('Pith\\Framework\\Internal\\DevIpAccessLevel');
            }

            // 'cron-ip' --- Only whitelisted IPs for running tasks
            elseif ($access_level_string === 'cron-ip') {
                $access_level = $this->dependency_injection->container->get('Pith\\Framework\\Internal\\CronIpAccessLevel');
            }

            // 'task' --- Only the task tool from terminal, or else whitelisted IPs for running tasks
            elseif ($access_level_string === 'task') {
                $access_level = $this->dependency_injection->container->get('Pith\\Framework\\Internal\\TaskAccessLevel');
            }

            // 'perform-user-login' --- Attempt to login user
            elseif ($access_level_string === 'perform-user-login') {
                $access_level = $this->dependency_injection->container->get('Pith\\Framework\\Internal\\PerformUserLoginAccessLevel');
            }

            // 'perform-user-logout' --- Attempt to logout user
            elseif ($access_level_string === 'perform-user-logout') {
                $access_level = $this->dependency_injection->container->get('Pith\\Framework\\Internal\\PerformUserLogoutAccessLevel');
            }

            // 'logout' --- Attempt to logout user
            elseif ($access_level_string === 'logout') {
                $access_level = $this->dependency_injection->container->get('Pith\\Framework\\Internal\\LogoutAccessLevel');
            }

            // 'user' --- Logged in user access only
            elseif ($access_level_string === 'user') {
                $access_level = $this->dependency_injection->container->get('Pith\\Framework\\Internal\\UserAccessLevel');
            }

            // 'webmaster' --- Webmaster access only
            elseif ($access_level_string === 'webmaster') {
                $access_level = $this->dependency_injection->container->get('Pith\\Framework\\Internal\\WebmasterAccessLevel');
            }

            // 'internal' --- Organization internal user access only
            elseif ($access_level_string === 'internal') {
                $access_level = $this->dependency_injection->container->get('Pith\\Framework\\Internal\\InternalAccessLevel');
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
        catch (Exception $exception){
            throw new PithException(
                'Pith Framework Exception 4030: The Access Control encountered a problem when running the Access Level. Message: ' . $exception->getMessage(),
                4030,
                $exception
            );
        }


        // After load
        if (!is_object($access_level)) {
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
        // Get app
        $app = $this->app_retriever->getApp();

        $process_type = $app->process->process_type;

        // Check access
        $is_allowed = $this->isAllowedToAccess($given_access_level_name);

        if($process_type === 'task'){
            if($is_allowed){
                // TODO - Probably log the task was allowed here.
                // TODO - Not the impression log, Create a Task Log to use here
            }
            else{
                // TODO - Probably log the task was failed here.
                throw new PithException(
                    'Pith Framework Exception 4031: Workflow element access denied for task.',
                    4031
                );
            }
        }
        else{
            if($is_allowed){
                // Log impression
                $app->active_user->logImpressionOnFirstAccessOnly($given_access_level_name, true);
            }
            else{
                // If not logged in:
                // T*O*D*O - Throw exception - Handle it and then - Deny & show the login page. Done.
                // If logged in:
                // TODO - Throw exception - Handle it and then - Deny & show the access denied page

                $is_logged_in = $app->active_user->isLoggedIn();
                if($is_logged_in){
                    // TODO Send to access denied page. (Need to make an access denied page first)
                }
                else{
                    // Redirect to user login form
                    header('Location: ' . PITH_APP_DEFAULT_LOGIN_PAGE_URL_PATH, true, 302);
                    exit;
                }

                /*
                throw new PithException(
                    'Pith Framework Exception 4007: Workflow element access denied.',
                    4007
                );
                */

                // Log impression
                $app->active_user->logImpressionOnFirstAccessOnly($given_access_level_name, false);

                // Set headers for 403
                http_response_code(403);
                echo 'Error 403';
                exit;
            }
        }
    }

    /**
     * @param int $user_id
     * @return array
     * @noinspection PhpUnnecessaryLocalVariableInspection
     */
    public function getUserAccessLevelsAboveUser(int $user_id): array
    {
        $user_access_levels_above_user = $this->user_service->getUserAccessLevelsAboveUser($user_id);

        return $user_access_levels_above_user;
    }
}