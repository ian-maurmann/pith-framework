<?php

/**
 * Login 2 Route
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PRS-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRoute;

/**
 * Class Login2Route
 */
class Login2Route extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'dev-ip';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\Login2ViewRequisition';
    public string $view             = '[^route_folder]/login-2-view.latte';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Login - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'login, demo, keyword, keywords';
    public string $meta_description = 'Login. Login page description here.';
}
