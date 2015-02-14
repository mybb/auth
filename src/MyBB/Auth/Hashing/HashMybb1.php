<?php namespace MyBB\Auth\Hashing;

use RuntimeException;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class HashMybb1 implements HasherContract
{
	/**
	 * A hasher is always singleton
	 *
	 * @var MyBB\Auth\Hashing\HashMybb1
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
	 * Hash the given value.
	 *
	 * @param  string  $value
	 * @param  array   $options
	 * @return string
	 *
	 * @throws \RuntimeException
	 */
	public function make($value, array $options = array())
	{
		// We need a salt to use mybb 1.x hashing algorithm - as we don't generate one here we're throwing an error
		if(empty($options['salt']))
		{
			throw new RuntimeException("No salt specified");
		}
		return md5(md5($options['salt']).md5($value));
	}

	/**
	 * Check the given plain value against a hash.
	 *
	 * @param  string  $value
	 * @param  string  $hashedValue
	 * @param  array   $options
	 * @return bool
	 */
	public function check($value, $hashedValue, array $options = array())
	{
		return ($hashedValue == $this->make($value, $options));
	}

	/**
	 * Check if the given hash has been hashed using the given options.
	 * As MyBB 1.x isn't using rehashes we're simply returning false here 
	 * 
	 * @param  string  $hashedValue
	 * @param  array   $options
	 * @return bool false
	 */
	public function needsRehash($hashedValue, array $options = array())
	{
		return false;
	}
}