<?php
/**
 * Hasher for legacy phpBB 3 passwords, using either BCrypt (3.1) or PHPass (before)
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Hashing\phpass\PasswordHash;

class HashPhpbb3 implements HasherContract
{
	/**
	 * @var PasswordHash
	 */
	private $phpass;

	/**
	 * @param PasswordHash $phpass
	 */
	public function __construct(PasswordHash $phpass)
	{
		$this->phpass = $phpass;
	}

	/**
	 * {@inheritdoc}
	 */
	public function make($value, array $options = array())
	{
		if (isset($options['hasher']) && $options['hasher'] == '3.0') {
			return $this->phpass->HashPassword($value);
		} else {
			// phpBB 3.1 still uses phpass to generate the salt - though they renamed the functions
			$salt = '$2y$10$' . $this->phpass->encode64($this->phpass->get_random_bytes(22), 22);

			return crypt($value, $salt);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function check($value, $hashedValue, array $options = array())
	{
		// The bcrypt hash is at least 60 chars and is used in phpBB 3.1
		if (strlen($hashedValue) >= 60 && $hashedValue == crypt($value, $hashedValue)) {
			return true;
		} // In 3.0 they used phpass
		elseif (strlen($hashedValue) == 34) {
			return $this->phpass->CheckPassword($value, $hashedValue);
		} // Before that basic md5 was used
		else {
			return md5($value) === $hashedValue;
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
