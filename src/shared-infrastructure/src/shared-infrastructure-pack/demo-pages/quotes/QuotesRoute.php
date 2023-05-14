<?php

/**
 * Quotes Route
 * ------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class QuotesRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class QuotesRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\QuotesAction';
    public string $preparer     = '\\Pith\\Framework\\SharedInfrastructure\\QuotesPreparer';
    public string $view         = '[^route_folder]/quotes-view.phtml';

    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';
    public string $page_title       = 'Quotes from Database - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'Quotes from database, quotes, database, keywords';
    public string $meta_description = 'Quotes. Quotes page description here.';
}
