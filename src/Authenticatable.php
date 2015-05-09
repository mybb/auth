<?php
/**
 * Authenticatable contract for MyBB 2.0
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth;

use Illuminate\Auth\Authenticatable as LaravelAuthenticatable;

trait Authenticatable
{
	use LaravelAuthenticatable;

	/**
	 * Get the username for the user
	 *
	 * @return string
	 */
	public function getUsername()
	{
		return $this->name;
	}

	/**
	 * Get the salt for the user
	 *
	 * @return string
	 */
	public function getSalt()
	{
		return $this->salt;
	}

	/**
	 * Get the hasher type for the user
	 *
	 * @return string
	 */
	public function getHasher()
	{
		return $this->hasher;
	}
}
