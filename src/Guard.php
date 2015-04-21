<?php
/**
 * Guard extension for MyBB 2.0.
 *
 * @version 2.0.0
 * @author  MyBB Group
 * @license LGPL v3
 */

namespace MyBB\Auth;

use Illuminate\Auth\Guard as IlluminateGuard;
use MyBB\Auth\Contracts\UserContract;
use MyBB\Auth\Contracts\Guard as GuardContract;

class Guard extends IlluminateGuard implements GuardContract
{
	/**
	 * @var UserContract
	 */
	protected $defaultUser;

	/**
	 * Register a default user to be used if no user is authenticated.
	 *
	 * @param UserContract $defaultUser The default user instance to use.
	 */
	public function registerDefaultUser(UserContract $defaultUser)
	{
		$this->defaultUser = $defaultUser;
	}

	/**
	 * Get the currently authenticated user.
	 *
	 * @return UserContract|null
	 */
	public function user()
	{
		$user = parent::user();

		if ($user === null) {
			return $this->defaultUser;
		}

		return $user;
	}

	/**
	 * Determine if the current user is authenticated.
	 *
	 * @return bool
	 */
	public function check()
	{
		$parentAns = parent::check();
		return $parentAns && ($this->user() != $this->defaultUser);
	}
}
