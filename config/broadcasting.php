<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcasting Driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default broadcaster that should be used by your
    | application. Supported drivers: "pusher", "redis", "log", "null".
    |
    */

    'default' => env('BROADCAST_DRIVER', 'pusher'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that your application
    | should use. You can configure each of the connections to be used with
    | the various broadcasting drivers such as Pusher, Redis, etc.
    |
    */

    'connections' => [
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true,
        ],
    ],

];
