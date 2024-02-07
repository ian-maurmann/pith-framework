<?php

/**
 * Footer Route
 * ------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

//use Pith\Workflow\PithRoute;
use Pith\Workflow\PithRoute;

/**
 * Class FooterRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class FooterRoute extends PithRoute
{
    public string $route_type   = 'partial';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\FooterAction';
    public string $preparer     = '\\Pith\\Framework\\SharedInfrastructure\\FooterPreparer';
    public string $view         = '[^route_folder]/footer-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
