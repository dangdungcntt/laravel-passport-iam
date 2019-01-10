# Integrate with Passport IAM

## Installation

You can install the package via composer:

```bash
composer require nddcoder/laravel-passport-iam
```

You can optionally publish the config file with:
```bash
php artisan vendor:publish --provider="Nddcoder\PassportIAM\IAMServiceProvider" --tag="config"
```

This is the contents of the published config file:
```php
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
```

## Config

#### Update config/auth.php

``` php
return [
    //...
    'guards' => [
        //...

        'api' => [
            'driver' => 'access_token',
            'provider' => 'tokens',
        ],
        //...
    ],
    //...
    'providers' => [
        //...

        'tokens' => [
            'driver' => 'token',
            'model' => App\User::class,
        ]

        //...
    ]
];
```

#### Fill info in .env

```
PASSPORT_IAM_BASE_URL=https://iam.domain.com
PASSPORT_IAM_CLIENT_ID=<passport_client_id>
PASSPORT_IAM_CLIENT_SECRET=<passport_client_secret>
```

## Usage

#### Login using email/password

```php
use Nddcoder\PassportIAM\Services\IAMServiceInterface;

$reponse = app(IAMServiceInterface::class)->login(['email' => 'email@example.com', 'passord' => 'secret']);

/*
{
  "token_type": "Bearer",
  "expires_in": 2592000,
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsI...",
  "refresh_token": "def50200ffa17b51e9e46117..."
}
*/
```

#### Valdiate token in request use middleware `auth:api`

```php
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/me', function(Request $request) {
        return $request->user();
    })
});
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
