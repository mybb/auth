<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Exceptions\HasherNoSaltException;

/**
 * Hasher for legacy PunBB passwords, using the following algorithm:
 *
 * <pre>
 * $password = sha1($salt . sha1($password));
 * </pre>
 *
 * Checks also fallbacks used in older versions
 *
 * @package MyBB\Auth
 */
class HashPunbb implements HasherContract
{
	/**
	 * {@inheritdoc}
	 */
	public function make($value, array $options = array())
	{
		// We need a salt to use punbb's hashing algorithm - as we don't generate one here we're throwing an error
		if (empty($options['salt'])) {
			throw new HasherNoSaltException;
		}

		return sha1($options['salt'] . sha1($value));
	}

	/**
	 * {@inheritdoc}
	 */
	public function check($value, $hashedValue, array $options = array())
	{
		if (strlen($hashedValue) == 40) {
			$is_sha1 = true;
		} else {
			$is_sha1 = false;
		}
		if (function_exists('sha1')
			&& $is_sha1
			&& (sha1($value) == $hashedValue || sha1($options['salt'].sha1($value)) == $hashedValue)
		) {
			return true;
		} elseif (function_exists('mhash')
			&& $is_sha1
			&& (bin2hex(mhash(MHASH_SHA1, $value)) == $hashedValue
				|| bin2hex(mhash(MHASH_SHA1, $options['salt'].bin2hex(mhash(MHASH_SHA1, $value)))) == $hashedValue)
		) {
			return true;
		} else {
			return md5($value) == $hashedValue;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function needsRehash($hashedValue, array $options = array())
	{
		return false;
	}
}
