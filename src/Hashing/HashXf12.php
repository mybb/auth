<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Hashing\phpass\PasswordHash;

/**
 * Hasher for legacy XenForo passwords, using some sort of PHPass -> to be confirmed
 *
 * @package MyBB\Auth
 */
class HashXf12 implements HasherContract
{
	private $phpass;

	public function __construct(PasswordHash $phpass)
	{
		// Originally XenForo modified the get_random_bytes function a bit
		// But as that function isn't used for checking passwords we're using standard phpass here
		$this->phpass = $phpass;
	}

	public function make($value, array $options = array())
	{
		return $this->phpass->HashPassword($value);
	}

	public function check($value, $hashedValue, array $options = array())
	{
		return $this->phpass->CheckPassword($value, $hashedValue);
	}

	public function needsRehash($hashedValue, array $options = array())
	{
		return false;
	}
}
