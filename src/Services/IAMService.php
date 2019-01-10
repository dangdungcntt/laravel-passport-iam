<?php

namespace Nddcoder\PassportIAM\Services;

use Nddcoder\HttpClient\HttpClient;

class IAMService implements IAMServiceInterface
{
    private $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function currentUser($token)
    {
        $url = config('passport-iam.base_url') . '/' . config('passport-iam.path.user');
        $response = $this->http->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ]
        ]);

        if (data_get($response, 'status_code') != 200) {
            return null;
        }

        return data_get($response, 'bodyJSON');
    }

    public function login($credentials)
    {
        $url = config('passport-iam.base_url') . '/' . config('passport-iam.path.oauth_token');
        $params = [
            'grant_type' => 'password',
            'client_id' => config('passport-iam.client_id'),
            'client_secret' => config('passport-iam.client_secret'),
            'username' => data_get($credentials, 'email'),
            'password' => data_get($credentials, 'password')
        ];

        return $this->http->post($url, [
            'form_params' => $params,
        ]);
    }
}
