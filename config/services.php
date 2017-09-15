<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Socialite Services
    |--------------------------------------------------------------------------
    |
    | Here, provide all the necessary authentication details for the Socialite
    | plugin. All of these, of course, should pull directly from the .env file.
    |
    */


    'facebook' => [
        'client_id'     => env('SOCIALITE_FB_CLIENT_ID'),
        'client_secret' => env('SOCIALITE_FB_CLIENT_SECRET'),
        'redirect'      => env('SOCIALITE_FB_URL'),
    ],

    'twitter' => [
        'client_id'     => env('SOCIALITE_TWITTER_CLIENT_ID'),
        'client_secret' => env('SOCIALITE_TWITTER_CLIENT_SECRET'),
        'redirect'      => env('SOCIALITE_TWITTER_URL'),
    ],

    'github' => [
        'client_id'     => env('SOCIALITE_GITHUB_CLIENT_ID'),
        'client_secret' => env('SOCIALITE_GITHUB_CLIENT_SECRET'),
        'redirect'      => env('SOCIALITE_GITHUB_URL'),
    ],

    'google' => [
        'client_id'     => env('SOCIALITE_GOOGLE_CLIENT_ID'),
        'client_secret' => env('SOCIALITE_GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('SOCIALITE_GOOGLE_URL'),
    ],

    'linkedin' => [
        'client_id'     => env('SOCIALITE_LINKEDIN_CLIENT_ID'),
        'client_secret' => env('SOCIALITE_LINKEDIN_CLIENT_SECRET'),
        'redirect'      => env('SOCIALITE_LINKEDIN_URL'),
    ],

    /*
    |--------------------------------------------------------------------------
    | IGDB Services
    |--------------------------------------------------------------------------
    |
    | Key and URL for the IGDB service.
    |
    */

    'igdb' => [
        'key' => env('IGDB_KEY'),
        'url' => env('IGDB_URL')
    ]

];
