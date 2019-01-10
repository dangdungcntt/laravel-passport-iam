<?php

return [
    'base_url' => env('PASSPORT_IAM_BASE_URL'),
    'path' => [
        'oauth_token' => 'oauth/token',
        'user' => 'api/user'
    ],
    'client_id' => env('PASSPORT_IAM_CLIENT_ID'),
    'client_secret' => env('PASSPORT_IAM_CLIENT_SECRET'),
    'common_fields' => explode(',', env('PASSPORT_IAM_COMMON_FIELDS')),
    'mapping_field' => [
        'iam' => 'uuid',
        'local' => 'uuid'
    ]
    
];

