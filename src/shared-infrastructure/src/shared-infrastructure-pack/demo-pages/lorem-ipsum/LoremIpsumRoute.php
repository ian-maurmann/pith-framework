<?php

/**
 * Lorem Ipsum Route
 * -----------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class LoremIpsumRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class LoremIpsumRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'world';
    public string $view         = '[^route_folder]/lorem-ipsum-view.phtml';
    public string $layout       = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Lorem Ipsum - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'Lorem Ipsum, lorem, ipsum, demo, keyword, keywords';
    public string $meta_description = 'Lorem Ipsum. Page description here.';
}
