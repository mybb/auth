<?php

namespace MyBB\Auth;

use Illuminate\Auth\AuthManager as LaravelManager;
use MyBB\Auth\Hashing\HashFactory;

/**
 * This class is only used to overwrite the eloquent driver to use our special one with the hash factory
 */
class AuthManager extends LaravelManager
{
    /**
     * Create an instance of the Eloquent user provider.
     *
     * @return \Illuminate\Auth\EloquentUserProvider
     */
    protected function createEloquentProvider()
    {
        $model = $this->app['config']['auth.model'];

        return new EloquentUserProvider(new HashFactory($this->app), $model);
    }
}
