<?php
/**
 * MyBB user provider.
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Hashing\HashFactory;

class MybbUserProvider extends EloquentUserProvider implements UserProvider
{
	/**
	 * @var HashFactory $hasherFactory
	 */
	protected $hasherFactory;

	/**
	 * Create a new MyBB user provider.
	 *
	 * @param HashFactory $hasherFactory Hasher factory to build hashers for legacy installs
	 *                                                             and imports.
	 * @param  \Illuminate\Contracts\Hashing\Hasher $hasher
	 * @param  string $model
	 */
	public function __construct(HashFactory $hasherFactory, HasherContract $hasher, $model)
	{
		parent::__construct($hasher, $model);
		$this->hasher = $hasherFactory;
	}

	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  \Illuminate\Contracts\Auth\Authenticatable $user
	 * @param  array $credentials
	 *
	 * @return bool
	 */
	public function validateCredentials(UserContract $user, array $credentials)
	{
		if (!($user instanceof MyBBUserContract)) {
			throw new \InvalidArgumentException("User must be an instance of MyBBUserContract");
		}

		$plain = $credentials['password'];

		dd($credentials);

		$hasher = $user->getHasher();

		if (is_null($hasher) || empty($hasher)) {
			$hasher = 'bcrypt';
		}

		// The factory needs to know the hashing type (null = bcrypt),
		// some hashing methods use a salt, other the username so we're also passing them
		return $this->hasherFactory->check($plain, $user->getAuthPassword(), [
			'name' => $user->getUserName(),
			'salt' => $user->getSalt(),
			'type' => $hasher,
		]);
	}
}