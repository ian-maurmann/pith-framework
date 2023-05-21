<?php

/**
 * Demonstrate Library: Toastr Route
 * ---------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class DemonstrateLibraryToastrRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryToastrRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'world';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryToastrViewRequisition';
    public string $view             = '[^route_folder]/demonstrate-library-toastr-view.phtml';
    public string $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Show that Toastr is working - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'Toastr, demo, keyword, keywords';
    public string $meta_description = 'Show that Toastr is working page description here.';
}
