<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Neshan API Key
    |--------------------------------------------------------------------------
    |
    | Your API key to access the Neshan Map services (Only for Static Map Service).
    | You can get this key from your Neshan developer dashboard.
    |
    */
    'static_map' => [
        'api_key' => env('NESHAN_STATIC_MAP_API_KEY', ''),
        'base_url' => env('NESHAN_STATIC_MAP_BASE_URL', 'https://api.neshan.org/v4/static'),
    ],


];
