<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Hashing\phpass\PasswordHash;

/**
 * Hasher for BBPress/Wordpress passwords, using PHPass
 *
 * @package MyBB\Auth
 */
class HashBbpress implements HasherContract
{
	private $phpass;

	public function __construct(PasswordHash $phpass)
	{
		$this->phpass = $phpass;
	}

	public function make($value, array $options = array())
	{
		return $this->phpass->HashPassword($value);
	}

	public function check($value, $hashedValue, array $options = array())
	{
		// WordPress (and so bbPress) used simple md5 hashing some time ago
		if ( strlen($hashedValue) <= 32 )
		{
			return ($hashedValue == md5($value));
		}
		else
		{
			return $this->phpass->CheckPassword($value, $hashedValue);
		}
	}

	public function needsRehash($hashedValue, array $options = array())
	{
		return false;
	}
}
