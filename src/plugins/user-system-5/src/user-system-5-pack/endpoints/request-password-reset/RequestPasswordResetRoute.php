<?php

/**
 * Request Password Reset Route
 * ----------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\UserSystem5;

use Pith\Workflow\PithRoute;

/**
 * Class RequestPasswordResetRoute
 */
class RequestPasswordResetRoute extends PithRoute
{
    public string $route_type   = 'endpoint';
    public string $pack         = '\\Pith\\Framework\\Plugin\\UserSystem5\\PithUserSystem5Pack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\Plugin\\UserSystem5\\RequestPasswordResetAction';
    public string $view_adapter = '\\Pith\\JsonEndpointViewAdapter\\PithJsonEndpointViewAdapter';
}
