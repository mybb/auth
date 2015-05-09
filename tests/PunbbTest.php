<?php
/**
 * Test PunBB Hasher
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

class PunbbTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var string
	 */
	private $hash = 'cf7b0ed34828fcbde66b671e90b1d6c2fd6e57eb';
	/**
	 * @var string
	 */
	private $salt = 'rF949)%).$@G';
	/**
	 * @var string
	 */
	private $utf8_hash = 'd1e8e70b7abba4698e671099b7d83f8b819017e3';
	/**
	 * @var string
	 */
	private $utf8_salt = 'BF*cL1%zI8T4';
	/**
	 * @var string
	 */
	private $password = 'thisismypassword';

	/**
	 * @var \MyBB\Auth\Hashing\HashPunbb
	 */
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
