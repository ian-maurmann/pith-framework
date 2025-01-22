<?php

/**
 * Demonstrate Library: Swal2NA Route
 * ------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRoute;

/**
 * Class DemonstrateLibrarySwal2NaRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibrarySwal2NaRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'dev-ip';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibrarySwal2NaViewRequisition';
    public string $view             = '[^route_folder]/demonstrate-library-swal2na-view.phtml';
    public string $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Show that Swal2NA is working - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'Swal2NA, demo, keyword, keywords';
    public string $meta_description = 'Show that Swal2NA is working page description here.';
}
