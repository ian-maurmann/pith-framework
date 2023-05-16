<?php

/**
 * Demonstrate Fontsheets Route
 * ----------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class DemonstrateFontsheetsRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateFontsheetsRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'world';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateFontsWorkViewRequisition';
    public string $view             = '[^route_folder]/demonstrate-fontsheets.latte';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Demonstrate that fontsheets work - '. PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'demonstrate fontsheets work, demonstrate,fonts, fonts, work keyword, keywords';
    public string $meta_description = 'Demonstrate that fontsheets work.';
}
