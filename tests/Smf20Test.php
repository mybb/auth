<?php
/**
 * Test SMF 2.0 Hasher
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

class Smf20Test extends PHPUnit_Framework_TestCase
{
	/**
	 * @var string
	 */
	private $hash = 'c73ba2982c55b7ead0e4098a92f722bdb3a3b3d8';
	/**
	 * @var string
	 */
	private $name = 'User';
	/**
	 * @var string
	 */
	private $utf8_hash = 'fb10111f401c01599157efc637c9cd0dd9870ea0';
	/**
	 * @var string
	 */
	private $utf8_name = 'Test';
	/**
	 * @var string
	 */
	private $password = 'thisismypassword';

	/**
	 * @var \MyBB\Auth\Hashing\HashSmf
	 */
	private $hasher;

	public function __construct()
	{
		require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
		require_once __DIR__.'/../src/Hashing/HashSmf.php';

		$this->hasher = new \MyBB\Auth\Hashing\HashSmf();
	}


	public function testHash()
	{
		$this->assertTrue($this->hasher->check('password', $this->hash, ['name' => $this->name, 'hasher' => '2.0']));
	}

	public function testUtf8Hash()
	{
		$this->assertTrue(
			$this->hasher->check('pässwörd', $this->utf8_hash, ['name' => $this->utf8_name, 'hasher' => '2.0'])
		);
	}

	public function testGenerateAndValidate()
	{
		$hash = $this->hasher->make($this->password, ['name' => $this->name, 'hasher' => '2.0']);

		$this->assertTrue($this->hasher->check($this->password, $hash, ['name' => $this->name, 'hasher' => '2.0']));
	}
}
