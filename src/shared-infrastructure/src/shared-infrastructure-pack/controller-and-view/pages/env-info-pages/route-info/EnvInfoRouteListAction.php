<?php

/**
 * Env Info - Route List Action
 * ----------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages;

use Pith\Workflow\PithAction;
use Pith\Framework\PithAppRetriever;

/**
 * Class EnvInfoRouteListAction
 * @package Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages
 */
class EnvInfoRouteListAction extends PithAction
{
    private PithAppRetriever $app_retriever;

    public function __construct(PithAppRetriever $app_retriever)
    {
        $this->app_retriever = $app_retriever;
    }

    public function runAction()
    {
        $app = $this->app_retriever->getApp();
        $routes = $app->config->getRoutes();

        // Push to Preparer
        $this->prepare->routes = $routes;
    }
}