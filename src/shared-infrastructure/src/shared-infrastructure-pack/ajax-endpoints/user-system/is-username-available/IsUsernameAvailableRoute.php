<?php

/**
 * Is Username Available Route
 * ---------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\UserSystemAjaxEndpoints;

use Pith\Framework\PithRoute;

/**
 * Class IsUsernameAvailableRoute
 * @package Pith\Framework\SharedInfrastructure\UserSystemAjaxEndpoints
 */
class IsUsernameAvailableRoute extends PithRoute
{
    public string $route_type   = 'endpoint';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\UserSystemAjaxEndpoints\\IsUsernameAvailableAction';
    public string $view_adapter = '\\Pith\\JsonEndpointViewAdapter\\PithJsonEndpointViewAdapter';
}
