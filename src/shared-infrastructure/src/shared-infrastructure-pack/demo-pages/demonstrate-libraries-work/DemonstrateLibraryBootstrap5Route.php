<?php

/**
 * Demonstrate Library: Bootstrap 5 Route
 * --------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class DemonstrateLibraryBootstrap5Route
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryBootstrap5Route extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'world';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryBootstrap5ViewRequisition';
    public string $view             = '[^route_folder]/demonstrate-library-bootstrap-5-view.phtml';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Show that Bootstrap 5 is working - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'Bootstrap 5, demo, keyword, keywords';
    public string $meta_description = 'Show that Bootstrap 5 is working page description here.';
}
