<?php

class Ipb4Test extends PHPUnit_Framework_TestCase
{
	/**
	 * @var string
	 */
	private $hash = '$2a$13$KbKf1LS4r6GC6QQS7eqmz.aGrfSCGLD664Q3LhLLskVGOiXa9dPs2';
	/**
	 * @var string
	 */
	private $salt = 'KbKf1LS4r6GC6QQS7eqmzF';
	/**
	 * @var string
	 */
	private $utf8_hash = '$2a$13$dHs7VNqIXxO9pfB00T1pMeKtcpFe.83os230MSomdbJnSrzL6icgm';
	/**
	 * @var string
	 */
	private $utf8_salt = 'dHs7VNqIXxO9pfB00T1pMj';
	/**
	 * @var string
	 */
	private $password = 'thisismypassword';

	/**
	 * @var \MyBB\Auth\Hashing\HashIpb4
	 */
	private $hasher;

	public function __construct()
	{
		require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
		require_once __DIR__.'/../src/Hashing/HashIpb4.php';

		$this->hasher = new \MyBB\Auth\Hashing\HashIpb4();
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
