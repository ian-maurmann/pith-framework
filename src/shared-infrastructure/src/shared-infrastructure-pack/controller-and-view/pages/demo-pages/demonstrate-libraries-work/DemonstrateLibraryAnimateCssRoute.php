<?php

/**
 * Demonstrate Library: Animate.css Route
 * ---------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRoute;

/**
 * Class DemonstrateLibraryAnimateCssRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryAnimateCssRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'dev-ip';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryAnimateCssViewRequisition';
    public string $view             = '[^route_folder]/demonstrate-library-animate-css-view.phtml';
    public string $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Show that Animate.css is working - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'home, demo, keyword, keywords';
    public string $meta_description = 'Home. Home page description here.';
}
