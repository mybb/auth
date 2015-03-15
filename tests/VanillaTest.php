<?php

class VanillaTest extends PHPUnit_Framework_TestCase  {
	private $hash = '$P$BaAvfJWlUGFb.7Gnmt1u4n4L5qkjn71';
	private $utf8_hash = '$P$B5mMvHVW.jdJ9gU873O4hjcnDu5m5N1';
	private $password = 'thisismypassword';

	private $hasher;

	public function __construct()
	{
		require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
		require_once __DIR__.'/../src/Hashing/HashVanilla.php';
		require_once __DIR__.'/../src/Hashing/phpass/PasswordHash.php';

		$phpass = new \MyBB\Auth\Hashing\phpass\PasswordHash(8, true);
		$phpass->PasswordHash(8, true);

		$this->hasher = new \MyBB\Auth\Hashing\HashVanilla($phpass);
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