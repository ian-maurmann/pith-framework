<?php

/**
 * User System Ajax Endpoints Route List
 * -------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);


namespace Pith\Framework\Plugin\UserSystem5;

use Pith\Workflow\PithRouteList;

/**
 * Class UserSystemAjaxEndpointsRouteList
 */
class UserSystemAjaxEndpointsRouteList extends PithRouteList
{
    public array $routes = [
        ['route', ['GET', 'POST'], '/create-new-user',       '\\Pith\\Framework\\Plugin\\UserSystem5\\CreateNewUserRoute'],
        ['route', ['GET', 'POST'], '/is-username-available', '\\Pith\\Framework\\Plugin\\UserSystem5\\IsUsernameAvailableRoute'],
    ];
}