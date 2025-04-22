<?php

/**
 * Demonstrate Loading-From-CDN route
 * ----------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRoute;

/**
 * Class DemonstrateLoadingFromCdnRoute
 */
class DemonstrateLoadingFromCdnRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'dev-ip';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\DemonstrateLoadingFromCdnViewRequisition';
    public string $view             = '[^route_folder]/demonstrate-loading-from-cdn.latte';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Demonstrate Loading-From-CDN - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'Load, CDN, demo, keyword, keywords';
    public string $meta_description = 'Demonstrate Loading-From-CDN.';
}
