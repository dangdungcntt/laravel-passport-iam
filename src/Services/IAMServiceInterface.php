<?php
/**
 * Created by PhpStorm.
 * User: dangdung
 * Date: 04/01/2019
 * Time: 00:19
 */

namespace Nddcoder\PassportIAM\Services;

interface IAMServiceInterface
{
    public function currentUser($token);

    public function login($credentials);
}
