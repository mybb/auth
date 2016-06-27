<?php
/**
 * MyBB authentication library service provider.
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth;

use MyBB\Auth\Hashing\HashFactory;

class AuthServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var \Illuminate\Auth\AuthManager $auth */
        $auth = $this->app['auth'];

        $auth->provider('mybb', function ($config) {
            return new MybbUserProvider(new HashFactory($this->app), $this->app['hash'], $config['model']);
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
