<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Hashing\phpass\PasswordHash;

/**
 * Hasher for PHPass Passwords
 *
 * @package MyBB\Auth
 */
class HashPhpass implements HasherContract
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
		return $this->phpass->HashPassword($value);
	}

	/**
	 * {@inheritdoc}
	 */
	public function check($value, $hashedValue, array $options = array())
	{
		return $this->phpass->CheckPassword($value, $hashedValue);
	}

	/**
	 * {@inheritdoc}
	 */
	public function needsRehash($hashedValue, array $options = array())
	{
		return false;
	}
}
