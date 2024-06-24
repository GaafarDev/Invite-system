<?php

return [

    'default' => env('FILESYSTEM_DISK', 'local'),

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        // Comment out unused s3 configuration
        // 's3' => [
        //     'driver' => 's3',
        //     'key' => env('AWS_ACCESS_KEY_ID', null),
        //     'secret' => env('AWS_SECRET_ACCESS_KEY', null),
        //     'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        //     'bucket' => env('AWS_BUCKET', null),
        //     'url' => env('AWS_URL', null),
        //     'endpoint' => env('AWS_ENDPOINT', null),
        //     'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        //     'throw' => false,
        // ],

    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
