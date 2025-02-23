<?php

/**
 * Logout Route
 * ------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PRS-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRoute;

/**
 * Class LogoutRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class LogoutRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'logout';
    public string $action           = '\\Pith\\Framework\\SharedInfrastructure\\LogoutAction';
    public string $view             = '[^route_folder]/logout-view.latte';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Logout - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'logout, demo, keyword, keywords';
    public string $meta_description = 'Logout. Logout page description here.';
}
