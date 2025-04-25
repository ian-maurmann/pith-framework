<?php

/**
 * Perform User Login Route
 * ------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PRS-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\Session;

use Pith\Workflow\PithRoute;

/**
 * Class PerformUserLoginRoute
 */
class PerformUserLoginRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\Plugin\\Session\\PithSessionPack';
    public string $access_level = 'perform-user-login';
    public string $view         = '[^route_folder]/perform-user-login-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';

    public string $page_title = '404 Not Found';
}
