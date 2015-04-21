<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Exceptions\HasherNoSaltException;

/**
 * Hasher for legacy IPB 4 passwords, using the following algorithm:
 *
 * <pre>
 * $password = crypt($password, '$2a$13$'.$salt);
 * </pre>
 *
 * @package MyBB\Auth
 */
class HashIpb4 implements HasherContract
{
	/**
	 * {@inheritdoc}
	 */
	public function make($value, array $options = array())
	{
		// We need a salt to use ipb's hashing algorithm - as we don't generate one here we're throwing an error
		if (empty($options['salt'])) {
			throw new HasherNoSaltException;
		}

		return crypt($value, '$2a$13$'.$options['salt']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function check($value, $hashedValue, array $options = array())
	{
		return ($hashedValue == $this->make($value, $options));
	}

	/**
	 * {@inheritdoc}
	 */
	public function needsRehash($hashedValue, array $options = array())
	{
		return false;
	}
}
