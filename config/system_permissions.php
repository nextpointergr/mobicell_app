<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Permission Groups
    |--------------------------------------------------------------------------
    */

    'groups' => [

        'dashboard' => [
            'label' => 'Dashboard',
            'guard' => 'admin',
            'permissions' => [
                'admin.dashboard.activity'  => 'View activity dashboard',

            ]
        ]


    ],

];
