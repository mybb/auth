<?php namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use RuntimeException;

class HashFactory implements HasherContract
{
	/**
	 * @var Application
	 */
	private $app;

	/**
	 * @param Application $app
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * {@inheritdoc}
	 */
	public function make($value, array $options = array())
	{
		$hasher = $this->getHasher($options['type']);

		return $hasher->make($value, $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function check($value, $hashedValue, array $options = array())
	{
		$hasher = $this->getHasher($options['type']);

		return $hasher->check($value, $hashedValue, $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function needsRehash($hashedValue, array $options = array())
	{
		$hasher = $this->getHasher($options['type']);

		return $hasher->needsRehash($hashedValue, $options);
	}

	/**
	 * Get's the actual hashing class for a specified hashing type
	 *
	 * @param string $hashName The name of the hashing class we should use.
	 *
	 * @return HasherContract The created hasher.
	 */
	protected function getHasher($hashName = 'bcrypt')
	{
		if (empty($hashName)) {
			$hashName = 'bcrypt';
		}

		$hasherClass = 'MyBB\\Auth\\Hashing\\Hash' . ucfirst($hashName);

		// Invalid hashing type
		if (!class_exists($hasherClass)) {
			throw new RuntimeException("Hasher '{$hasherClass}' does not exist");
		}

		$hasher = $this->app->make($hasherClass);

		if (!$hasher || !($hasher instanceof HasherContract)) {
			throw new RuntimeException("Failed to initialise hasher '{$hasherClass}'");
		}

		return $hasher;
	}
}
