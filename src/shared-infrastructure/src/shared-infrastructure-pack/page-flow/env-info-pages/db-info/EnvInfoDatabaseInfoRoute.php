<?php

/**
 * Env-Info - Database Info Route
 * ------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class EnvInfoDatabaseInfoRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class EnvInfoDatabaseInfoRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'dev-ip';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\EnvInfoDatabaseInfoAction';
    public string $view         = '[^route_folder]/env-info-database-info.latte';
    public string $layout       = '\\Pith\\Framework\\SharedThemePack\\EnvInfoLayoutRoute';

    public string $page_title       = 'Latte - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'Using Latte, demo, keyword, keywords';
    public string $meta_description = 'Using Latte page description here.';
}
