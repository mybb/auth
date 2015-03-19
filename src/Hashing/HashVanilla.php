<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Hashing\phpass\PasswordHash;

/**
 * Hasher for legacy Vanilla passwords, using PHPass
 *
 * @package MyBB\Auth
 */
class HashVanilla extends HashPhpass
{
	public function check($value, $hashedValue, array $options = array())
	{
		if($hashedValue[0] === '_' || $hashedValue[0] === '$')
		{
			return parent::check($value, $hashedValue, $options);
		}
		elseif($value && $hashedValue !== '*' && ($value === $hashedValue || md5($value) === $hashedValue))
		{
			return true;
		}
		return false;
	}
}
