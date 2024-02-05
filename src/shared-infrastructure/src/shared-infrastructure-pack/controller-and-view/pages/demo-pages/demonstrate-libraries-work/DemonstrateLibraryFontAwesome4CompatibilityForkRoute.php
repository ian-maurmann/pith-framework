<?php

/**
 * Demonstrate Library: FontAwesome4 Compatibility Fork Route
 * ----------------------------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRoute;

/**
 * Class DemonstrateLibraryFontAwesome4CompatibilityForkRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryFontAwesome4CompatibilityForkRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'dev-ip';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryFontAwesome4CompatibilityForkViewRequisition';
    public string $view             = '[^route_folder]/demonstrate-library-font-awesome-4-compatibility-fork-view.phtml';
    public string $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Show that Font Awesome 4 and 6 are working - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'Font Awesome 4 and 6, demo, keyword, keywords';
    public string $meta_description = 'Font Awesome 4 and 6 Compatibility Fork page description here.';
}
