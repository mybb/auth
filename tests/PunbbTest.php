<?php

class PunbbTest extends PHPUnit_Framework_TestCase
{
	private $hash = 'cf7b0ed34828fcbde66b671e90b1d6c2fd6e57eb';
	private $salt = 'rF949)%).$@G';
	private $utf8_hash = 'd1e8e70b7abba4698e671099b7d83f8b819017e3';
	private $utf8_salt = 'BF*cL1%zI8T4';
	private $password = 'thisismypassword';

	private $hasher;

	public function __construct()
	{
		require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
		require_once __DIR__.'/../src/Hashing/HashPunbb.php';

		$this->hasher = new \MyBB\Auth\Hashing\HashPunbb();
	}


	public function testHash()
	{
		$this->assertTrue($this->hasher->check('password', $this->hash, ['salt' => $this->salt]));
	}

	public function testUtf8Hash()
	{
		$this->assertTrue($this->hasher->check('pässwörd', $this->utf8_hash, ['salt' => $this->utf8_salt]));
	}

	public function testGenerateAndValidate()
	{
		$hash = $this->hasher->make($this->password, ['salt' => $this->salt]);

		$this->assertTrue($this->hasher->check($this->password, $hash, ['salt' => $this->salt]));
	}
}
