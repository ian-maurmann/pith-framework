<?php

/**
 * User System Ajax Endpoints Route List
 * -------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\SharedInfrastructure\UserSystemAjaxEndpoints;

use Pith\Framework\PithRouteList;

/**
 * Class UserSystemAjaxEndpointsRouteList
 * @package Pith\Framework\SharedInfrastructure\UserSystemAjaxEndpoints
 */
class UserSystemAjaxEndpointsRouteList extends PithRouteList
{
    public array $routes = [
        ['route', ['GET', 'POST'], '/is-username-available', '\\Pith\\Framework\\SharedInfrastructure\\UserSystemAjaxEndpoints\\IsUsernameAvailableRoute'],
    ];
}