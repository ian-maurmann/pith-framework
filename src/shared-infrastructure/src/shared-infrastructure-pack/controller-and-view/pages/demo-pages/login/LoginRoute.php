<?php

/**
 * Login Route
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PRS-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class NewUserRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class LoginRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'dev-ip';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\LoginViewRequisition';
    public string $view             = '[^route_folder]/login-view.latte';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Login - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'login, demo, keyword, keywords';
    public string $meta_description = 'Login. Login page description here.';
}
