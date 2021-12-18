<?php
// config for JWCobb/LaravelToolkit
return [

    /*
    |--------------------------------------------------------------------------
    | Site Variables
    |--------------------------------------------------------------------------
    |
    | This section is for setting default variables for common page and
    | meta properties. Each of these can be overridden within each page
    | but defaults should be established here.
    |
    */

//    'page_title'       => env('SITE_PAGE_TITLE'),
//    'page_description' => env('SITE_PAGE_DESCRIPTION'),
//    'page_keywords'    => env('SITE_PAGE_KEYWORDS'),

    'copyright_first_start' => env('COPYRIGHT_FIRST_YEAR', date('Y')),

    'social' => [
        'facebook' => [
            'url' => env('SOCIAL_FACEBOOK_URL', null),
        ],
        'instagram' => [
            'url' => env('SOCIAL_INSTAGRAM_URL', null),
        ],
        'linkedin' => [
            'url' => env('SOCIAL_LINKEDIN_URL', null),
        ],
        'pinterest' => [
            'url' => env('SOCIAL_PINTEREST_URL', null),
        ],
        'tiktok' => [
            'url' => env('SOCIAL_TIKTOK_URL', null),
        ],
        'twitter' => [
            'url' => env('SOCIAL_TWITTER_URL', null),
            'username' => env('SOCIAL_TWITTER_USERNAME', null),
        ],
        'youtube' => [
            'url' => env('SOCIAL_YOUTUBE_URL', null),
        ],
    ],

    'google' => [
        'tracking_id' => env('GOOGLE_TRACKING_ID', null),
    ],

    'description' => [
        'default' => 'This is my site',
    ],

];
