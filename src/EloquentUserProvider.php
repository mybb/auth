<?php
/**
 * User Provider for MyBB 2.0.
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth;

use Illuminate\Auth\EloquentUserProvider as LaravelUser;
use Illuminate\Contracts\Auth\Authenticatable as LaravelUserContract;
use MyBB\Auth\Contracts\UserContract;
use MyBB\Auth\Exceptions\AuthNotMybbInstanceException;

class EloquentUserProvider extends LaravelUser
{
	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  LaravelUserContract $user        Needs to be MyBB\Auth\Contracts\UserContract (checked in the method)
	 * @param  array               $credentials
	 *
	 * @return bool
	 *
	 * @throws AuthNotMybbInstanceException Thrown if $user does not implement \MyBB\Auth\Contracts\UserContract.
	 */
	public function validateCredentials(LaravelUserContract $user, array $credentials)
	{
		// Check whether it's a MyBB valid user
		if (!($user instanceof UserContract)) {
			throw new AuthNotMybbInstanceException;
		}

		$plain = $credentials['password'];

		// The factory needs to know the hashing type (null = bcrypt),
		// some hashing methods use a salt, other the username so we're also passing them
		return $this->hasher->check($plain, $user->getAuthPassword(), [
			'name' => $user->getUsername(),
			'salt' => $user->getSalt(),
			'type' => $user->getHasher()
		]);
	}
}
