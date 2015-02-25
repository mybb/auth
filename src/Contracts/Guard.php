<?php
/**
 * Guard contract extension for MyBB 2.0.
 *
 * @version 2.0.0
 * @author  MyBB Group
 * @license LGPL v3
 */

namespace MyBB\Auth\Contracts;

interface Guard extends \Illuminate\Contracts\Auth\Guard
{
	/**
	 * Register a default user to be used if no user is authenticated.
	 *
	 * @param UserContract $defaultUser The default user instance to use.
	 */
	public function registerDefaultUser(UserContract $defaultUser);
}
