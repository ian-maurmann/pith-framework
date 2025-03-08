<?php

/**
 * Create New User Route
 * ---------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\UserSystem3;

use Pith\Workflow\PithRoute;

/**
 * Class CreateNewUserRoute
 */
class CreateNewUserRoute extends PithRoute
{
    public string $route_type   = 'endpoint';
    public string $pack         = '\\Pith\\Framework\\Plugin\\UserSystem3\\PithUserSystem3Pack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\Plugin\\UserSystem3\\CreateNewUserAction';
    public string $view_adapter = '\\Pith\\JsonEndpointViewAdapter\\PithJsonEndpointViewAdapter';
}
