<?php
/**
 * Created by PhpStorm.
 * User: dangdung
 * Date: 10/01/2019
 * Time: 13:35
 */

return [
    'base_url' => env('PASSPORT_IAM_BASE_URL'),
    'client_id' => env('PASSPORT_IAM_CLIENT_ID'),
    'client_secret' => env('PASSPORT_IAM_CLIENT_SECRET'),
    'common_fields' => explode(',', env('PASSPORT_IAM_COMMON_FIELDS'))
];

