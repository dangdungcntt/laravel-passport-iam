<?php
/**
 * Created by PhpStorm.
 * User: dangdung
 * Date: 03/01/2019
 * Time: 23:36
 */

namespace Nddcoder\PassportIAM\Services;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\UserProvider;

class TokenToUserProvider extends EloquentUserProvider implements UserProvider
{
    public function retrieveByToken($identifier, $token)
    {
        $iamUser = app(IAMServiceInterface::class)->currentUser($token);
        $user = empty($iamUser) ? null :
            $this->retrieveByCredentials(['uuid' => data_get($iamUser, 'uuid')]);

        if (empty($user)) {
            return null;
        }

        foreach (config('passport-iam.common_fields') as $field) {
            if (empty($field)) continue;
            $user->{$field} = data_get($iamUser, $field);
        }

        return $user;
    }
}
