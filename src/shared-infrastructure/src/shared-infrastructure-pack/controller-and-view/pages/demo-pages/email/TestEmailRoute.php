<?php

/**
 * Test Email route
 * ----------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRoute;

/**
 * Class TestEmailRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class TestEmailRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'dev-ip';
    public string $view         = '[^route_folder]/test-email.latte';
    public string $layout       = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLatteLayoutRoute';

    public string $page_title       = 'Test Email - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'Test email, demo, keyword, keywords';
    public string $meta_description = 'Test email page description here.';
}
