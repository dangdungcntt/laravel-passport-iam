<?php

namespace Nddcoder\PassportIAM\Services;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class IAMGuard implements Guard
{
    use GuardHelpers;

    private $inputKey = '';
    private $storageKey = '';
    private $request;
    public function __construct (UserProvider $provider, Request $request, $config) {
        $this->provider = $provider;
        $this->request = $request;

        $this->inputKey = isset($config['input_key']) ? $config['input_key'] : 'access_token';
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }
        $user = null;
        // retrieve via token
        $token = $this->getTokenForRequest();
        if (!empty($token)) {
            // the token was found, how you want to pass?
            $user = $this->provider->retrieveByToken(null, $token);
        }
        return $this->user = $user;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $token = $credentials[$this->inputKey];

        if (empty($token)) {
            return false;
        }

        if ($this->provider->retrieveByToken(null, $token)) {
            return true;
        }
        return false;
    }

    /**
     * Get the token for the current request.
     * @return string
     */
    public function getTokenForRequest()
    {
        $token = $this->request->query($this->inputKey);
        if (empty($token)) {
            $token = $this->request->input($this->inputKey);
        }
        if (empty($token)) {
            $token = $this->request->bearerToken();
        }
        return $token;
    }
}
