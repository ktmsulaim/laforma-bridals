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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],
    'mailjet' => [
        'key' => env('MAILJET_APIKEY', 'b7cdf4668a8290720945549f9efbe790'),
        'secret' => env('MAILJET_APISECRET', '46e1a4d65e6778b8bb9b3a24fc8b7157'),
        'transactional' => [
            'call' => true,
            'options' => [
                'url' => 'api.mailjet.com',
                'version' => 'v3.1',
                'call' => true,
                'secured' => true
            ]
        ],
        'common' => [
            'call' => true,
            'options' => [
                'url' => 'api.mailjet.com',
                'version' => 'v3',
                'call' => true,
                'secured' => true
            ]
        ],
        'v4' => [
            'call' => true,
            'options' => [
                'url' => 'api.mailjet.com',
                'version' => 'v4',
                'call' => true,
                'secured' => true
            ]
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

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', '627842087471-sb2r9hran6vqu1qo01jnqnvtfgqce076.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', '5qrEr4rXnRgyfCUPmQ3YVqhy'),
        'redirect' => env('GOOGLE_REDIRECT_URI')
    ],
    'facebook' => [    
        'client_id' => env('FACEBOOK_CLIENT_ID', '986746178791118'),  
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', '27623d24a74a7cf41320a4717ab2057a'),  
        'redirect' => env('FACEBOOK_REDIRECT_URI') 
    ],

];
