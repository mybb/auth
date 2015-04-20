<?php

class Mybb1Test extends PHPUnit_Framework_TestCase
{
	private $hash = '9bab3ea951024a935075ca5c9ef6d42d';
	private $salt = '1QI52qWp';
	private $utf8_hash = '93692cf2eaee0df690031a79b4511df9';
	private $utf8_salt = 'Emxu7r8j';
	private $password = 'thisismypassword';

	private $hasher;

	public function __construct()
	{
		require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
		require_once __DIR__.'/../src/Hashing/HashMybb1.php';

		$this->hasher = new \MyBB\Auth\Hashing\HashMybb1();
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
