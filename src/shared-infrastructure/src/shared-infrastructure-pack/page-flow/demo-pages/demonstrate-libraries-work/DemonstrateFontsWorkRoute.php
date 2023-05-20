<?php

/**
 * Demonstrate Fonts Work Route
 * --------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class DemonstrateFontsWorkRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateFontsWorkRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'world';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateFontsWorkViewRequisition';
    public string $view             = '[^route_folder]/demonstrate-fonts-work.phtml';
    public string $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Demonstrate that fonts work - '. PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'demonstrate fonts work, demonstrate,fonts, fonts, work keyword, keywords';
    public string $meta_description = 'Demonstrate that fonts work.';
}
