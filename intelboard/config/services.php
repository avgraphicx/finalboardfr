<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT'),
    ],

    'stripe' => [
        'prices' => [
            'bronze' => [
                'monthly' => env('STRIPE_BRONZE_MONTHLY_PRICE_ID', 'price_1PQSfHRpS4YVz6cW2g5eYxkj'),
                'quarterly' => env('STRIPE_BRONZE_QUARTERLY_PRICE_ID', 'price_1PQSfHRpS4YVz6cW2g5eYxkj'),
                'semiannually' => env('STRIPE_BRONZE_SEMIANNUAL_PRICE_ID', 'price_1PQSfHRpS4YVz6cW2g5eYxkj'),
                'yearly' => env('STRIPE_BRONZE_YEARLY_PRICE_ID', 'price_1PQSfHRpS4YVz6cW2g5eYxkj'),
            ],
            'gold' => [
                'monthly' => env('STRIPE_GOLD_MONTHLY_PRICE_ID', 'price_1PQSfhRpS4YVz6cW3gQ8gohK'),
                'quarterly' => env('STRIPE_GOLD_QUARTERLY_PRICE_ID', 'price_1PQSfhRpS4YVz6cW3gQ8gohK'),
                'semiannually' => env('STRIPE_GOLD_SEMIANNUAL_PRICE_ID', 'price_1PQSfhRpS4YVz6cW3gQ8gohK'),
                'yearly' => env('STRIPE_GOLD_YEARLY_PRICE_ID', 'price_1PQSfhRpS4YVz6cW3gQ8gohK'),
            ],
            'diamond' => [
                'monthly' => env('STRIPE_DIAMOND_MONTHLY_PRICE_ID', 'price_1PQSgBRpS4YVz6cW2sDxA2R1'),
                'quarterly' => env('STRIPE_DIAMOND_QUARTERLY_PRICE_ID', 'price_1PQSgBRpS4YVz6cW2sDxA2R1'),
                'semiannually' => env('STRIPE_DIAMOND_SEMIANNUAL_PRICE_ID', 'price_1PQSgBRpS4YVz6cW2sDxA2R1'),
                'yearly' => env('STRIPE_DIAMOND_YEARLY_PRICE_ID', 'price_1PQSgBRpS4YVz6cW2sDxA2R1'),
            ],
        ],
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
