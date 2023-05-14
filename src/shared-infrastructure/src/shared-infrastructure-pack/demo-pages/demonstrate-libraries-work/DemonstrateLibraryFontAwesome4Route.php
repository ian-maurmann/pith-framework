<?php

/**
 * Demonstrate Library: FontAwesome4 Route
 * ---------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class DemonstrateLibraryFontAwesome4Route
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryFontAwesome4Route extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'world';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryFontAwesome4ViewRequisition';
    public string $view             = '[^route_folder]/demonstrate-library-font-awesome-4-view.phtml';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Show that Font Awesome 4 is working - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'Font Awesome 4, demo, keyword, keywords';
    public string $meta_description = 'Font Awesome 4 demo page description here.';
}
