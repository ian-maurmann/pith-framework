<?php

/**
 * Demonstrate Library: Hoja Aquamarine Route
 * ------------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class DemonstrateLibraryHojaAquamarineRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryHojaAquamarineRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'world';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLibraryHojaAquamarineViewRequisition';
    public string $view             = '[^route_folder]/demonstrate-library-hoja-aquamarine-view.phtml';
    public string $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Show that Hola Aquamarine is working - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'Hola Aquamarine, demo, keyword, keywords';
    public string $meta_description = 'Hola Aquamarine page description here.';
}
