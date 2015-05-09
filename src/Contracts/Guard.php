<?php
/**
 * Guard contract extension for MyBB 2.0.
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
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
