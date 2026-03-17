<?php

return [

    'stores' => [

        'central' => [
            'base_url' => env('PYLON_CENTRAL_URL'),
            'apicode' => env('PYLON_CENTRAL_APICODE'),
            'databasealias' => env('PYLON_CENTRAL_DB'),
            'username' => env('PYLON_CENTRAL_USER'),
            'password' => env('PYLON_CENTRAL_PASS'),
            'applicationname' => env('PYLON_APP', 'Hercules.MyPylonCommercial'),
        ],

    ]

];