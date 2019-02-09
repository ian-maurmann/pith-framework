<?php


// Config Profile Name
$config_profile->name = 'Example Config Profile';


// Route-space paths
$config_profile->route_spaces = [

    [
        'module'      => 'Pith\\WhiteModule\\WhiteModule',
        'route-space' => 'main-route-space',
        'match'       => '/white',
    ],
    
    [
        'module'      => 'Pith\\GreenModule\\GreenModule',
        'route-space' => 'main-route-space',
        'match'       => '/green',
    ],

];
