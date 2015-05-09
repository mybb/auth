<?php
/**
 * MyBB 2 user contract
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth\Contracts;

use Illuminate\Contracts\Auth\Authenticatable as LaravelUserContract;

interface UserContract extends LaravelUserContract
{
	/**
	 * Get the username for the user
	 *
	 * @return string
	 */
	public function getUsername();

	/**
	 * Get the salt for the user
	 *
	 * @return string
	 */
	public function getSalt();

	/**
	 * Get the hasher type for the user
	 *
	 * @return string
	 */
	public function getHasher();
}
