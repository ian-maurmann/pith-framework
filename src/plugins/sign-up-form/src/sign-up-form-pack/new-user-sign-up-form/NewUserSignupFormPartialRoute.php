<?php

/**
 * New User Signup Form Partial Route
 * ----------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok here.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\SignUpForm;

use Pith\Workflow\PithRoute;

/**
 * Class NewUserSignupFormPartialRoute
 */
class NewUserSignupFormPartialRoute extends PithRoute
{
    public string $route_type   = 'partial';
    public string $pack         = '\\Pith\\Framework\\Plugin\\SignUpForm\\PithSignUpFormPack';
    public string $access_level = 'world';
    public string $action       = '\\Pith\\Framework\\Plugin\\SignUpForm\\NewUserSignupFormPartialAction';
    public string $view         = '[^route_folder]/new-user-signup-form-partial-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
