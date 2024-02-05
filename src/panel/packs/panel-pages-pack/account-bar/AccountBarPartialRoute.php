<?php

/**
 * Account Bar Partial Route
 * -------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok here.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel\Pages;

use Pith\Workflow\PithRoute;

/**
 * Class AccountBarPartialRoute
 * @package Pith\Framework\Panel\Pages
 */
class AccountBarPartialRoute extends PithRoute
{
    public string $route_type   = 'partial';
    public string $pack         = '\\Pith\\Framework\\Panel\\Pages\\PithPanelPagesPack';
    public string $access_level = 'internal';
    public string $action       = '\\Pith\\Framework\\Panel\\Pages\\AccountBarAction';
    public string $view         = '[^route_folder]/account-bar-partial-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
