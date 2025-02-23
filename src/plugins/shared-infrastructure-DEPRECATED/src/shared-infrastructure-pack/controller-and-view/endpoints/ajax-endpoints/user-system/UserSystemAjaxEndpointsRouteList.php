<?php

/**
 * User System Ajax Endpoints Route List
 * -------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\Endpoints\UserSystemAjaxEndpoints;

use Pith\Workflow\PithRouteList;

/**
 * Class UserSystemAjaxEndpointsRouteList
 * @package Pith\Framework\SharedInfrastructure\Endpoints\UserSystemAjaxEndpoints
 */
class UserSystemAjaxEndpointsRouteList extends PithRouteList
{
    public array $routes = [
        ['route', ['GET', 'POST'], '/create-new-user',       '\\Pith\\Framework\\SharedInfrastructure\\Endpoints\\UserSystemAjaxEndpoints\\CreateNewUserRoute'],
        ['route', ['GET', 'POST'], '/is-username-available', '\\Pith\\Framework\\SharedInfrastructure\\Endpoints\\UserSystemAjaxEndpoints\\IsUsernameAvailableRoute'],
    ];
}