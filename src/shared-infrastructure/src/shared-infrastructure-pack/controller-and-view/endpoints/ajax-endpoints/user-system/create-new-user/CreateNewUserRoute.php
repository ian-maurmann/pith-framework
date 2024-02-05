<?php

/**
 * Create New User Route
 * ---------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Endpoints\UserSystemAjaxEndpoints;

use Pith\Workflow\PithRoute;

/**
 * Class CreateNewUserRoute
 * @package Pith\Framework\SharedInfrastructure\Endpoints\UserSystemAjaxEndpoints
 */
class CreateNewUserRoute extends PithRoute
{
    public string $route_type   = 'endpoint';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\Endpoints\\UserSystemAjaxEndpoints\\CreateNewUserAction';
    public string $view_adapter = '\\Pith\\JsonEndpointViewAdapter\\PithJsonEndpointViewAdapter';
}
