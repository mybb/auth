<?php
/**
 * Hasher for legacy WCF 2 passwords, using the following algorithm:
 *
 * <pre>
 * $password = crypt(crypt($password, $salt), $salt);
 * </pre>
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Exceptions\HasherNoSaltException;

class HashWcf2 implements HasherContract
{
	/**
	 * {@inheritdoc}
	 */
	public function make($value, array $options = [])
	{
		// We need a salt to use wcf2's hashing algorithm - as we don't generate one here we're throwing an error
		if (empty($options['salt'])) {
			throw new HasherNoSaltException;
		}

		return crypt(crypt($value, $options['salt']), $options['salt']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function check($value, $hashedValue, array $options = [])
	{
		$salt = substr($hashedValue, 0, 29);

		return (crypt(crypt($value, $salt), $salt) == $hashedValue);
	}

	/**
	 * {@inheritdoc}
	 */
	public function needsRehash($hashedValue, array $options = [])
	{
		return false;
	}
}
