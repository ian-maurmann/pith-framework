<?php

/**
 * Error 403 Route
 * ---------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\ErrorPages;

use Pith\Workflow\PithRoute;

/**
 * Class Error403Route
 */
class Error403Route extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\Plugin\\ErrorPages\\ErrorPagesPack';
    public string $access_level = 'world';
    public string $view         = '[^route_folder]/error-403-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';

    public string $page_title = '403 Forbidden';
}
