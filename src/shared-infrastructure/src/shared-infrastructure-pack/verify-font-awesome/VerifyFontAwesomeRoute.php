<?php

/**
 * Verify Font Awesome Route
 * ----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class VerifyFontAwesomeRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class VerifyFontAwesomeRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'world';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\VerifyFontAwesomeViewRequisition';
    public string $view             = '[^route_folder]/verify-font-awesome-view.phtml';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Home';
    public string $meta_keywords    = 'home, demo, keyword, keywords';
    public string $meta_description = 'Home. Home page description here.';
}
