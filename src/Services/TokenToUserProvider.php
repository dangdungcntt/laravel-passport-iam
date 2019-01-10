<?php

namespace Nddcoder\PassportIAM\Services;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\UserProvider;

class TokenToUserProvider extends EloquentUserProvider implements UserProvider
{
    public function retrieveByToken($identifier, $token)
    {
        $iamUser = app(IAMServiceInterface::class)->currentUser($token);
        $user = empty($iamUser) ? null :
            $this->retrieveByCredentials([
                config('passport-iam.mapping_field.local') => data_get($iamUser, config('passport-iam.mapping_field.iam'))
            ]);

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
