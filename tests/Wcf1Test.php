<?php

// TODO: WCF 1 has a lot of settings, add new test (cases) for them and generate original passwords
class Wcf1Test extends PHPUnit_Framework_TestCase
{
	/**
	 * @var string
	 */
	private $hash = 'dd03ae9f52883b374695e5b541c9490ed4ba9d08';
	/**
	 * @var string
	 */
	private $salt = '5650b3ce4bf73d4862de7cb92e730e88a27fa533';
	/**
	 * @var string
	 */
	private $utf8_hash = '85ae03b6cb310bddc8308072c4f4edd10f5121c0';
	/**
	 * @var string
	 */
	private $utf8_salt = 'a0a944e504fc40afcbe6e0fd5b905ec724bfbc23';
	/**
	 * @var string
	 */
	private $password = 'thisismypassword';

	/**
	 * @var \MyBB\Auth\Hashing\HashWcf1
	 */
	private $hasher;

	public function __construct()
	{
		require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
		require_once __DIR__.'/../src/Hashing/HashWcf1.php';

		$this->hasher = new \MyBB\Auth\Hashing\HashWcf1();
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
