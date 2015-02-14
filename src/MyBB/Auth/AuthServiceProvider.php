<?php namespace MyBB\Auth;

use Illuminate\Auth\AuthServiceProvider as LaravelAuth;

/**
 * This class is only used to register our own subclass of the AuthManager instead of Laravel's default one
 */

class AuthServiceProvider extends LaravelAuth
{

	/**
	 * Register the authenticator services.
	 *
	 * @return void
	 */
	protected function registerAuthenticator()
	{
		$this->app->singleton('auth', function($app)
		{
			// Once the authentication service has actually been requested by the developer
			// we will set a variable in the application indicating such. This helps us
			// know that we need to set any queued cookies in the after event later.
			$app['auth.loaded'] = true;
			return new AuthManager($app);
		});
		$this->app->singleton('auth.driver', function($app)
		{
			return $app['auth']->driver();
		});
	}
}