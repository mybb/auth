<?php
/**
 * Hasher for legacy SMF passwords, using different algorithms in different versions
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Exceptions\HasherNoUsernameException;

class HashSmf implements HasherContract
{

	/**
	 * {@inheritdoc}
	 */
	public function make($value, array $options = array())
	{
		if (empty($options['name'])) {
			throw new HasherNoUsernameException;
		}

		if (!isset($options['hasher'])) {
			$options['hasher'] = '2.1';
		}

		if ($options['hasher'] == '2.0') {
			return $this->md5Hmac($options['name'], $value);
		} elseif ($options['hasher'] == 'sha1') {
			return sha1(strtolower($options['name']).$value);
		} else {
			// Prefix the password with the username as SMF 2.1 does
			$value = strtolower($options['name']).$value;

			// Nothing so see here, SMF's way of creating a salt

			// The length of salt to generate
			$raw_salt_len = 16;
			// The length required in the final serialization
			$required_salt_len = 22;
			$hash_format = "$2y$10$";

			$buffer = '';
			$buffer_valid = false;
			if (function_exists('mcrypt_create_iv') && !defined('PHALANGER')) {
				$buffer = mcrypt_create_iv($raw_salt_len, MCRYPT_DEV_URANDOM);
				if ($buffer) {
					$buffer_valid = true;
				}
			}
			if (!$buffer_valid && function_exists('openssl_random_pseudo_bytes')) {
				$buffer = openssl_random_pseudo_bytes($raw_salt_len);
				if ($buffer) {
					$buffer_valid = true;
				}
			}
			if (!$buffer_valid && @is_readable('/dev/urandom')) {
				$f = fopen('/dev/urandom', 'r');
				$read = mb_strlen($buffer, '8bit');
				while ($read < $raw_salt_len) {
					$buffer .= fread($f, $raw_salt_len - $read);
					$read = mb_strlen($buffer, '8bit');
				}
				fclose($f);
				if ($read >= $raw_salt_len) {
					$buffer_valid = true;
				}
			}
			if (!$buffer_valid || mb_strlen($buffer, '8bit') < $raw_salt_len) {
				$bl = mb_strlen($buffer, '8bit');
				for ($i = 0; $i < $raw_salt_len; $i++) {
					if ($i < $bl) {
						$buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
					} else {
						$buffer .= chr(mt_rand(0, 255));
					}
				}
			}
			$salt = $buffer;

			// encode string with the Base64 variant used by crypt
			$base64_digits =
				'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
			$bcrypt64_digits =
				'./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

			$base64_string = base64_encode($salt);
			$salt = strtr(rtrim($base64_string, '='), $base64_digits, $bcrypt64_digits);

			$salt = mb_substr($salt, 0, $required_salt_len, '8bit');

			$hash = $hash_format . $salt;

			return crypt($value, $hash);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function check($value, $hashedValue, array $options = array())
	{
		if (empty($options['name'])) {
			throw new HasherNoUsernameException;
		}

		$is_sha1 = false;
		if (strlen($hashedValue) == 40) {
			$is_sha1 = true;
		}

		if ($is_sha1 && sha1(strtolower($options['name']).$value) == $hashedValue) {
			return true;
		} else {
			// Prefix the password with the username as SMF 2.1 does
			if (crypt(strtolower($options['name']).$value, $hashedValue) == $hashedValue) {
				return true;
			} elseif (strlen($hashedValue) == 32 && $this->md5Hmac($options['name'], $value) == $hashedValue) {
				return true;
			} elseif (strlen($hashedValue) == 32 && md5($value) == $hashedValue) {
				return true;
			}
		}

		// While we encode everything in utf8, smf doesn't do so by default
		// so if we have a different utf8 representation of the password we try that too
		if (utf8_decode($value) !== $value) {
			return $this->check(utf8_decode($value), $hashedValue, $options);
		}

		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function needsRehash($hashedValue, array $options = array())
	{
		return false;
	}

	/**
	 * @param string $username
	 * @param string $password
	 *
	 * @return string
	 */
	private function md5Hmac($username, $password)
	{
		if (strlen($username) > 64) {
			$username = pack('H*', md5($username));
		}
		$username = str_pad($username, 64, chr(0x00));
		$k_ipad = $username ^ str_repeat(chr(0x36), 64);
		$k_opad = $username ^ str_repeat(chr(0x5c), 64);
		return md5($k_opad.pack('H*', md5($k_ipad.$password)));
	}
}
