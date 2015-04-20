<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use RuntimeException;

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
	public function make($value, array $options = array())
	{
		// We need a salt to use ipb's hashing algorithm - as we don't generate one here we're throwing an error
		if (empty($options['salt'])) {
			throw new RuntimeException("No salt specified");
		}

		return crypt($value, '$2a$13$'.$options['salt']);
	}

	public function check($value, $hashedValue, array $options = array())
	{
		return ($hashedValue == $this->make($value, $options));
	}

	public function needsRehash($hashedValue, array $options = array())
	{
		return false;
	}
}
