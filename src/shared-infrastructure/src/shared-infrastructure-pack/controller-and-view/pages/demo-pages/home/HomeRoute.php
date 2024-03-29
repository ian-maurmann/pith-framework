<?php

/**
 * Home Route
 * ----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Short property names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRoute;

/**
 * Class HomeRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class HomeRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'dev-ip';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\HomeViewRequisition';
    public string $view             = '[^route_folder]/home-view.phtml';
    public string $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Home - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'home, demo, keyword, keywords';
    public string $meta_description = 'Home. Home page description here.';
}
