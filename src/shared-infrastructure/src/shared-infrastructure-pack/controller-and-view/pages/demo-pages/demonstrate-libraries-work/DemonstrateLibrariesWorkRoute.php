<?php

/**
 * Demonstrate Libraries Work Route
 * --------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class DemonstrateLibrariesWorkRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibrariesWorkRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'dev-ip';
    public string $view         = '[^route_folder]/demonstrate-libraries-work.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
    public string $layout       = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Demonstrate that libraries work - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'demonstrate libraries work, demonstrate,library, libraries, work keyword, keywords';
    public string $meta_description = 'Demonstrate that libraries work.';
}
