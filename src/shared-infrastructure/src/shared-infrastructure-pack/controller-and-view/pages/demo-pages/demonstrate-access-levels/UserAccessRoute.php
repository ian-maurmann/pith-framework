<?php

/**
 * User Access Route
 * -----------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpIllegalPsrClassPathInspection      - PSR-4.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class UserAccessRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class UserAccessRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'dev-ip';
    public string $view         = '[^route_folder]/lorem-ipsum-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
    public string $layout       = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Demonstrate Access-Levels - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'demonstrate access levels, lorem, ipsum, demo, keyword, keywords';
    public string $meta_description = 'Demonstrate Access-Levels. Page description here.';
}
