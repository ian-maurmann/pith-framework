<?php

/**
 * Tasks Route
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel\Pages;

use Pith\Framework\PithRoute;

/**
 * Class TasksRoute
 * @package Pith\Framework\Panel\Pages
 */
class TasksRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\Panel\\Pages\\PithPanelPagesPack';
    public string $access_level = 'webmaster';
    public string $view         = '[^route_folder]/tasks-view.latte';
    public string $layout       = '\\Pith\\Framework\\Panel\\Theme\\MainLayoutRoute';

    public string $page_title       = 'Pith Panel';
    public string $meta_keywords    = 'pith panel, pith framework';
    public string $meta_description = 'Website internal-user panel for internal use.';

    public string $meta_robots = 'noindex, nofollow';
}
