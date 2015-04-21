<?php
/**
 * Auth manager extension for MyBB 2.0. Uses the custom Guard instance to add registering of a default user.
 *
 * @version 2.0.0
 * @author  MyBB Group
 * @license LGPL v3
 */

namespace MyBB\Auth;

use Illuminate\Auth\AuthManager as LaravelManager;
use Illuminate\Auth\DatabaseUserProvider;
use MyBB\Auth\Hashing\HashFactory;

/**
 * This class is only used to overwrite the eloquent driver to use our special one with the hash factory
 */
class AuthManager extends LaravelManager
{
	/**
	 * Create a new driver instance.
	 *
	 * @param  string $driver
	 *
	 * @return mixed
	 */
	protected function createDriver($driver)
	{
		$guard = parent::createDriver($driver);

		// When using the remember me functionality of the authentication services we
		// will need to be set the encryption instance of the guard, which allows
		// secure, encrypted cookie values to get generated for those cookies.
		$guard->setCookieJar($this->app['cookie']);

		$guard->setDispatcher($this->app['events']);

		return $guard->setRequest($this->app->refresh('request', $guard, 'setRequest'));
	}

	/**
	 * Call a custom driver creator.
	 *
	 * @param  string $driver
	 *
	 * @return Guard
	 */
	protected function callCustomCreator($driver)
	{
		$custom = parent::callCustomCreator($driver);

		if ($custom instanceof \Illuminate\Contracts\Auth\Guard) {
			return $custom;
		}

		return new Guard($custom, $this->app['session.store']);
	}

	/**
	 * Create an instance of the database driver.
	 *
	 * @return Guard
	 */
	public function createDatabaseDriver()
	{
		$provider = $this->createDatabaseProvider();

		return new Guard($provider, $this->app['session.store']);
	}

	/**
	 * Create an instance of the database user provider.
	 *
	 * @return \Illuminate\Auth\DatabaseUserProvider
	 */
	protected function createDatabaseProvider()
	{
		$connection = $this->app['db']->connection();

		// When using the basic database user provider, we need to inject the table we
		// want to use, since this is not an Eloquent model we will have no way to
		// know without telling the provider, so we'll inject the config value.
		$table = $this->app['config']['auth.table'];

		return new DatabaseUserProvider($connection, $this->app['hash'], $table);
	}

	/**
	 * Create an instance of the Eloquent driver.
	 *
	 * @return Guard
	 */
	public function createEloquentDriver()
	{
		$provider = $this->createEloquentProvider();

		return new Guard($provider, $this->app['session.store']);
	}

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

	/**
	 * Get the default authentication driver name.
	 *
	 * @return string
	 */
	public function getDefaultDriver()
	{
		return $this->app['config']['auth.driver'];
	}

	/**
	 * Set the default authentication driver name.
	 *
	 * @param  string $name
	 *
	 * @return void
	 */
	public function setDefaultDriver($name)
	{
		$this->app['config']['auth.driver'] = $name;
	}
}
