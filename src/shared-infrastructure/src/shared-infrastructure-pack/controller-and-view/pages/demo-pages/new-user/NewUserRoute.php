<?php

/**
 * New User Route
 * --------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class NewUserRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class NewUserRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'dev-ip';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\NewUserViewRequisition';
    public string $view             = '[^route_folder]/new-user-view.latte';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'New User - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'new user, demo, keyword, keywords';
    public string $meta_description = 'New User. New User page description here.';
}
