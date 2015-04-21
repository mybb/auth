<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use RuntimeException;

/**
 * Hasher for legacy WCF 1 passwords, using the following algorithm:
 * Note that WCF 1 has some options for their passwords
 *
 * @package MyBB\Auth
 */
class HashWcf1 implements HasherContract
{
	const SALT_POS_BEFORE = 'before';
	const SALT_POS_AFTER = 'after';

	const ENABLE_SALT = 'encryption_enable_salting';
	const SALT_POS = 'encryption_salt_position';
	const ENCRYPT_BEFORE_SALTING = 'encryption_encrypt_before_salting';
	const HASHING_METHOD = 'encryption_method';

	/**
	 * {@inheritdoc}
	 */
	public function make($value, array $options = array())
	{
		// We need a salt to use wcf1's hashing algorithm - as we don't generate one here we're throwing an error
		if (empty($options['salt'])) {
			throw new RuntimeException("No salt specified");
		}

		$options = array_merge(
			[
				static::HASHING_METHOD => 'sha1',
				static::ENABLE_SALT => true,
				static::SALT_POS => static::SALT_POS_BEFORE,
				static::ENCRYPT_BEFORE_SALTING => true,
			],
			$options
		);

		return $this->encrypt(
			$options['salt'] . $this->hash($value, $options['salt'], $options),
			$options[static::HASHING_METHOD]
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function check($value, $hashedValue, array $options = array())
	{
		return ($hashedValue == $this->make($value, $options));
	}

	/**
	 * {@inheritdoc}
	 */
	public function needsRehash($hashedValue, array $options = array())
	{
		return false;
	}

	/**
	 * @param string $value
	 * @param string $method
	 *
	 * @return int|string
	 */
	private function encrypt($value, $method)
	{
		switch ($method) {
			case 'sha1':
				return sha1($value);
			case 'md5':
				return md5($value);
			case 'crc32':
				return crc32($value);
			case 'crypt':
				return crypt($value);
		}
	}

	/**
	 * @param string $value
	 * @param string $salt
	 * @param array  $settings
	 *
	 * @return int|string
	 */
	private function hash($value, $salt, array $settings)
	{
		if ($settings[static::ENABLE_SALT]) {
			$hash = '';
			// salt
			if ($settings[static::SALT_POS] == static::SALT_POS_BEFORE) {
				$hash .= $salt;
			}
			// value
			if ($settings[static::ENCRYPT_BEFORE_SALTING]) {
				$hash .= $this->encrypt($value, $settings[static::HASHING_METHOD]);
			} else {
				$hash .= $value;
			}
			// salt
			if ($settings[static::SALT_POS] == static::SALT_POS_AFTER) {
				$hash .= $salt;
			}
			return $this->encrypt($hash, $settings[static::HASHING_METHOD]);
		} else {
			return $this->encrypt($value, $settings[static::HASHING_METHOD]);
		}
	}
}
