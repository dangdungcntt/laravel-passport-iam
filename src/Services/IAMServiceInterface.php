<?php

namespace Nddcoder\PassportIAM\Services;

interface IAMServiceInterface
{
    public function currentUser($token);

    public function login($credentials);
}
