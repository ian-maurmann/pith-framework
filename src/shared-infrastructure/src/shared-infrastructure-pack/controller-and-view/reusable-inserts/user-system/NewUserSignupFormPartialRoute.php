<?php

/**
 * New User Signup Form Partial Route
 * ----------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok here.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\ReusableInserts\UserSystemReusableInserts;

use Pith\Framework\PithRoute;

/**
 * Class NewUserSignupFormPartialRoute
 * @package Pith\Framework\SharedInfrastructure\ReusableInserts\UserSystemReusableInserts
 */
class NewUserSignupFormPartialRoute extends PithRoute
{
    public string $route_type   = 'partial';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\ReusableInserts\\UserSystemReusableInserts\\NewUserSignupFormPartialAction';
    public string $view         = '[^route_folder]/new-user-signup-form-partial-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
