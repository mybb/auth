<?php namespace MyBB\Auth\Hashing;

use RuntimeException;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Hash;

class HashBcrypt implements HasherContract
{
	/**
	 * A hasher is always singleton
	 *
	 * @var MyBB\Auth\Hashing\HashBcrypt
	 */
	private static $instance = null;
	private function __construct() {}
	public static function getInstance()
	{
		if(static::$instance == null)
		{
			static::$instance = new self();
		}

		return static::$instance;
	}

	/**
	 * This is only a wrapper to use Laravel's Bcrypt hasher. Used like this to avoid special checks in the factory
	 */
	public function make($value, array $options = array())
	{
		return Hash::make($value, $options);
	}

	public function check($value, $hashedValue, array $options = array())
	{
		return Hash::check($value, $hashedValue, $options);
	}

	public function needsRehash($hashedValue, array $options = array())
	{
		return Hash::needsRehash($hashedValue, $options);
	}
}