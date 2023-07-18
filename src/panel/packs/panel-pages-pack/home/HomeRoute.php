<?php

/**
 * Home Route
 * ----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel\Pages;

use Pith\Framework\PithRoute;

/**
 * Class HomeRoute
 * @package Pith\Framework\Panel\Pages
 */
class HomeRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\Panel\\Pages\\PithPanelPagesPack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\Panel\\Pages\\HomeAction';
    public string $view         = '[^route_folder]/home-view.latte';
    public string $layout       = '\\Pith\\Framework\\Panel\\Theme\\MainLayoutRoute';

    public string $page_title       = 'Pith Panel';
    public string $meta_keywords    = 'pith panel, pith framework';
    public string $meta_description = 'Website internal-user panel for internal use.';

    public string $meta_robots = 'noindex, nofollow';
}
