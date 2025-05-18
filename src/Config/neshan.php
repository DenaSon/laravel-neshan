<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Static Map Service Configuration
    |--------------------------------------------------------------------------
    |
    | This section holds the API key and base URL for accessing Neshan's
    | Static Map Service. You can generate a static image of a specific
    | location using this service.
    |
    */
    'static_map' => [
        'api_key'   => env('NESHAN_STATIC_MAP_API_KEY', ''),
        'base_url'  => env('NESHAN_STATIC_MAP_BASE_URL', 'https://api.neshan.org/v4/static'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Search Service Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the Neshan Search Service. This service allows you
    | to search places based on a keyword and a geographic coordinate.
    |
    | - `api_key`: Your unique key for Search API access.
    | - `base_url`: Endpoint for the search service (usually doesn't change).
    |
    */
    'search' => [
        'api_key'   => env('NESHAN_SEARCH_API_KEY', ''),
        'base_url'  => env('NESHAN_SEARCH_BASE_URL', 'https://api.neshan.org/v1/search'),
    ],

];
