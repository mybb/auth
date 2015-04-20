<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

/**
 * Hasher for BBPress/Wordpress passwords, using PHPass
 *
 * @package MyBB\Auth
 */
class HashBbpress extends HashPhpass
{
	public function check($value, $hashedValue, array $options = array())
	{
		// WordPress (and so bbPress) used simple md5 hashing some time ago
		if (strlen($hashedValue) <= 32) {
			return ($hashedValue == md5($value));
		}

		// PHPass passwords
		return parent::check($value, $hashedValue, $options);
	}
}
