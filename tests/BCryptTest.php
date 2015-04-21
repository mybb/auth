<?php

class BCryptTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var string
	 */
	private $hash = '$2y$10$piBefrVszhfeZ7Jk8yLlYulIqTWziP3SdNYYdntPOVROtQ/S2m2Ky';
	/**
	 * @var string
	 */
	private $utf8_hash = '$2y$10$y3QFHbnXU4aY4hTlNIPfaukMXv9T23KNV5rPlGAud5idizsEQyEGe';
	/**
	 * @var string
	 */
	private $password = 'thisismypassword';

	/**
	 * @var \MyBB\Auth\Hashing\HashBcrypt
	 */
	private $hasher;

	public function __construct()
	{
		require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
		require_once __DIR__.'/../vendor/illuminate/Hashing/BcryptHasher.php';
		require_once __DIR__.'/../src/Hashing/HashBcrypt.php';

		$bcrypt = new \Illuminate\Hashing\BcryptHasher();
		$this->hasher = new \MyBB\Auth\Hashing\HashBcrypt($bcrypt);
	}


	public function testHash()
	{
		$this->assertTrue($this->hasher->check('password', $this->hash));
	}

	public function testUtf8Hash()
	{
		$this->assertTrue($this->hasher->check('pässwörd', $this->utf8_hash));
	}

	public function testGenerateAndValidate()
	{
		$hash = $this->hasher->make($this->password);

		$this->assertTrue($this->hasher->check($this->password, $hash));
	}
}
