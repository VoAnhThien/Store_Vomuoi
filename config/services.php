<?php

return [

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
        // Với môi trường local trên Windows, thường dễ lỗi SSL do thiếu cacert.
        // Nếu bạn đã cấu hình cacert trong php.ini thì có thể bỏ hẳn phần 'guzzle' này.
        'guzzle' => [
            // Tạm tắt verify SSL cho môi trường phát triển local.
            // KHÔNG nên dùng cấu hình này trên server production.
            'verify' => false,
        ],
    ],
];
