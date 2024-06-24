<?php

return [

    'default' => env('QUEUE_CONNECTION', 'database'),

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'connection' => env('DB_QUEUE_CONNECTION', null),
            'table' => env('DB_QUEUE_TABLE', 'jobs'),
            'queue' => env('DB_QUEUE', 'default'),
            'retry_after' => (int) env('DB_QUEUE_RETRY_AFTER', 90),
            'after_commit' => false,
        ],

        // Comment out unused configurations
        // 'beanstalkd' => [
        //     'driver' => 'beanstalkd',
        //     'host' => env('BEANSTALKD_QUEUE_HOST', 'localhost'),
        //     'queue' => env('BEANSTALKD_QUEUE', 'default'),
        //     'retry_after' => (int) env('BEANSTALKD_QUEUE_RETRY_AFTER', 90),
        //     'block_for' => 0,
        //     'after_commit' => false,
        // ],

        // 'sqs' => [
        //     'driver' => 'sqs',
        //     'key' => env('AWS_ACCESS_KEY_ID', null),
        //     'secret' => env('AWS_SECRET_ACCESS_KEY', null),
        //     'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
        //     'queue' => env('SQS_QUEUE', 'default'),
        //     'suffix' => env('SQS_SUFFIX', null),
        //     'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        //     'after_commit' => false,
        // ],

        // 'redis' => [
        //     'driver' => 'redis',
        //     'connection' => env('REDIS_QUEUE_CONNECTION', 'default'),
        //     'queue' => env('REDIS_QUEUE', 'default'),
        //     'retry_after' => (int) env('REDIS_QUEUE_RETRY_AFTER', 90),
        //     'block_for' => null,
        //     'after_commit' => false,
        // ],

    ],

    'batching' => [
        'database' => env('DB_CONNECTION', 'sqlite'),
        'table' => 'job_batches',
    ],

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'sqlite'),
        'table' => 'failed_jobs',
    ],

];
