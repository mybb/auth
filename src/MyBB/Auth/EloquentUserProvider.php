<?php

namespace MyBB\Auth;

use Illuminate\Auth\EloquentUserProvider as LaravelUser;
use Illuminate\Contracts\Auth\Authenticatable as LaravelUserContract;
use MyBB\Auth\Contracts\UserContract;

class EloquentUserProvider extends LaravelUser
{
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user - We need to use Laravel's Interface to overwrite the
     *                                                          method properly, however it should be an instance of
     *                                                          MyBB\Auth\Contracts\UserContract (checked in the
     *                                                          method)
     * @param  array                                      $credentials
     *
     * @return bool
     * @throws \RuntimeException Thrown if $user does not implement \MyBB\Auth\Contracts\UserContract.
     */
    public function validateCredentials(LaravelUserContract $user, array $credentials)
    {
        // Check whether it's a MyBB valid user
        if (!($user instanceof UserContract)) {
            throw new \RuntimeException('User is not instance of MyBB\\Auth\\Contracts\\UserContract');
        }

        $plain = $credentials['password'];

        // The factory needs to know the hashing type (null = bcrypt), some hashing methods use a salt, other the username so we're also passing them
        return $this->hasher->check($plain, $user->getAuthPassword(), [
            'name' => $user->getUsername(),
            'salt' => $user->getSalt(),
            'type' => $user->getHasher()
        ]
        );
    }

}
