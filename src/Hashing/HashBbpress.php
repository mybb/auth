<?php
/**
 * Hasher for BBPress/Wordpress passwords, using PHPass
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class HashBbpress extends HashPhpass
{
	/**
	 * {@inheritdoc}
	 */
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
