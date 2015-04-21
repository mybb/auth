<?php

class PhpassTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var string
	 */
	private $hash = '$P$BxlUyAJ0Nz3sCU1YLlqjcOdzZ2m2wa1';
	/**
	 * @var string
	 */
	private $utf8_hash = '$P$B2qcq0GdT9.K18G1vW8sHrMzpbMagb/';
	/**
	 * @var string
	 */
	private $password = 'thisismypassword';

	/**
	 * @var \MyBB\Auth\Hashing\HashPhpass
	 */
	private $hasher;

	public function __construct()
	{
		require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
		require_once __DIR__.'/../src/Hashing/phpass/PasswordHash.php';
		require_once __DIR__.'/../src/Hashing/HashPhpass.php';

		$phpass = new \MyBB\Auth\Hashing\phpass\PasswordHash(8, true);
		$phpass->PasswordHash(8, true);

		$this->hasher = new \MyBB\Auth\Hashing\HashPhpass($phpass);
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
