<?php

/**
 * Latte Route
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class LatteRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class LatteRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\LatteAction';
    public string $preparer     = '\\Pith\\Framework\\SharedInfrastructure\\LattePreparer';
    public string $view         = '[^route_folder]/template.latte';
    public string $view_adapter = '\\Pith\\LatteViewAdapter\\PithLatteViewAdapter';
    public string $layout       = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Latte - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'Using Latte, demo, keyword, keywords';
    public string $meta_description = 'Using Latte page description here.';
}
