<?php
/**
 * Hasher for legacy IPB 2/3 passwords, using the same algoritm as MyBB 1.x used
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth\Hashing;

class HashIpb extends HashMybb1
{
	/**
	 * {@inheritdoc}
	 */
	public function make($value, array $options = [])
	{
		// This is IPB's way of filtering input - the rest of the hashing is the same we use
		$value = str_replace("&", "&amp;", $value);
		$value = str_replace("<!--", "&#60;&#33;--", $value);
		$value = str_replace("-->", "--&#62;", $value);
		$value = str_ireplace("<script", "&#60;script", $value);
		$value = str_replace(">", "&gt;", $value);
		$value = str_replace("<", "&lt;", $value);
		$value = str_replace('"', "&quot;", $value);
		$value = str_replace("\n", "<br />", $value);
		$value = str_replace("$", "&#036;", $value);
		$value = str_replace("!", "&#33;", $value);
		$value = str_replace("'", "&#39;", $value);

		return parent::make($value, $options);
	}
}
