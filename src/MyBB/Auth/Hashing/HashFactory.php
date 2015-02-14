<?php namespace MyBB\Auth\Hashing;

use RuntimeException;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class HashFactory implements HasherContract
{
	/**
	 * A factory is always singleton
	 * 
	 * @var MyBB\Auth\Hashing\HashFactory
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
	 * As we're implementing Laravel's hasher interface we need to have make, check and needsRehash. However the "work" will be done in the different classes
	 */
	public function make($value, array $options = array())
	{
		$hasher = $this->getHasher($options['type']);
		return $hasher->make($value, $options);
	}

	public function check($value, $hashedValue, array $options = array())
	{
		$hasher = $this->getHasher($options['type']);
		return $hasher->check($value, $hashedValue, $options);
	}

	public function needsRehash($hashedValue, array $options = array())
	{
		$hasher = $this->getHasher($options['type']);
		return $hasher->needsRehash($hashedValue, $options);
	}

	/**
	 * Get's the actual hashing class for a specified hashing type
	 * 
	 * @param string $hashName The name of the hashing class we should use
	 * @return Illuminate\Contracts\Hashing\Hasher
	 */
	protected function getHasher($hashName)
	{
		// Defaults to bcrypt
		if(empty($hashName))
		{
			$hashName = "bcrypt";
		}

		// Namespace the class properly
		$class = "MyBB\Auth\Hashing\Hash".ucfirst($hashName);

		// Invalid hashing type
		if(!class_exists($class))
		{
			throw new RuntimeException("Hasher {$hashName} is not supported");
		}

		$i = $class::getInstance();

		// Make sure the hasher implements the correct interface
		if(!($i instanceof HasherContract))
		{
			throw new RuntimeException("Hasher {$hashName} isn't instance of Illuminate\Contracts\Hashing\Hasher");
		}

		return $i;
	}
}