<?php
/**
 * Hasher for legacy vB passwords, using the following algorithm:
 *
 * <pre>
 * $password = md5(md5($password) . $salt);
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

class HashVb implements HasherContract
{
	/**
	 * {@inheritdoc}
	 */
	public function make($value, array $options = [])
	{
		// We need a salt to use vb's hashing algorithm - as we don't generate one here we're throwing an error
		if (empty($options['salt'])) {
			throw new HasherNoSaltException;
		}

		return md5(md5($value) . $options['salt']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function check($value, $hashedValue, array $options = [])
	{
		// We need a salt to use vb's hashing algorithm - as we don't generate one here we're throwing an error
		if (empty($options['salt'])) {
			throw new HasherNoSaltException;
		}

		if ($hashedValue == $this->make($value, $options)) {
			return true;
		} // The password wasn't hashed in all versions
		elseif ($hashedValue == md5($value . $options['salt'])) {
			return true;
		}

		// While we encode everything in utf8, vb doesn't do so by default
		// so if we have a different utf8 representation of the password we try that too
		if (utf8_decode($value) !== $value) {
			return $this->check(utf8_decode($value), $hashedValue, $options);
		}

		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function needsRehash($hashedValue, array $options = [])
	{
		return false;
	}
}
