<?php

/**
 * Demonstrate Library: Jscrollpane Route
 * --------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class DemonstrateLibraryJscrollpaneRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryJscrollpaneRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'dev-ip';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryJscrollpaneViewRequisition';
    public string $view             = '[^route_folder]/demonstrate-library-jscrollpane-view.phtml';
    public string $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Show that jScrollPane is working - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'jScrollPane, demo, keyword, keywords';
    public string $meta_description = 'Show that jScrollPane is working page description here.';
}
