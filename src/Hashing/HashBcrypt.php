<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Hashing\BcryptHasher;

class HashBcrypt implements HasherContract
{
	/**
	 * @var BcryptHasher
	 */
	private $hasher;

	/**
	 * @param BcryptHasher $hasher
	 */
	public function __construct(BcryptHasher $hasher)
	{
		$this->hasher = $hasher;
	}

	/**
	 * {@inheritdoc}
	 */
	public function make($value, array $options = array())
	{
		return $this->hasher->make($value, $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function check($value, $hashedValue, array $options = array())
	{
		return $this->hasher->check($value, $hashedValue, $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function needsRehash($hashedValue, array $options = array())
	{
		return $this->hasher->needsRehash($hashedValue, $options);
	}
}
