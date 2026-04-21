<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google API Credentials
    |--------------------------------------------------------------------------
    */
    'service' => [
        'enable' => env('GOOGLE_SERVICE_ENABLED', true),
        'file' => base_path(env('GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION', 'storage/app/google-credentials.json')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Sheets Config
    |--------------------------------------------------------------------------
    */
    'spreadsheet_id' => env('GOOGLE_SPREADSHEET_ID', ''),

    'sheet_name' => env('GOOGLE_SHEET_NAME', 'Sheet1'),
];
