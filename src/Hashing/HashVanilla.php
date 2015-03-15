<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Hashing\phpass\PasswordHash;

/**
 * Hasher for legacy Vanilla passwords, using PHPass
 *
 * @package MyBB\Auth
 */
class HashVanilla implements HasherContract
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
		if($hashedValue[0] === '_' || $hashedValue[0] === '$')
		{
			return $this->phpass->CheckPassword($value, $hashedValue);
		}
		elseif($value && $hashedValue !== '*' && ($value === $hashedValue || md5($value) === $hashedValue))
		{
			return true;
		}
		return false;
	}

	public function needsRehash($hashedValue, array $options = array())
	{
		return false;
	}
}
