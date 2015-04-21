<?php

class Wcf2Test extends PHPUnit_Framework_TestCase
{
	/**
	 * @var string
	 */
	private $hash = '$2a$08$GpZxdMN7ALevHBBMYl.DWOrJZ4h/zLAXRTrucTMhZFK3oowDwl5Ne';
	/**
	 * @var string
	 */
	private $salt = 'GpZxdMN7ALevHBBMYl';
	/**
	 * @var string
	 */
	private $utf8_hash = '$2a$08$TwmAsMQ2.Bs1mUmlLPcgNejptHSSvYvr6nbDKsEGOhg9VVi1wKD62';
	/**
	 * @var string
	 */
	private $utf8_salt = 'TwmAsMQ2.Bs1mUmlLP';
	/**
	 * @var string
	 */
	private $password = 'thisismypassword';

	/**
	 * @var \MyBB\Auth\Hashing\HashWcf2
	 */
	private $hasher;

	public function __construct()
	{
		require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
		require_once __DIR__.'/../src/Hashing/HashWcf2.php';

		$this->hasher = new \MyBB\Auth\Hashing\HashWcf2();
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
