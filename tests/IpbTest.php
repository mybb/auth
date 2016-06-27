<?php
/**
 * Test IPB < 4 Hasher
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

class IpbTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $hash = '7e6f3724d991b5b7c96411abfcb7928c';
    /**
     * @var string
     */
    private $salt = 'GN53]';
    /**
     * @var string
     */
    private $utf8_hash = 'b794917b289e73dbe67d90c02c501173';
    /**
     * @var string
     */
    private $utf8_salt = '2$![1';
    /**
     * @var string
     */
    private $password = 'thisismypassword';

    /**
     * @var \MyBB\Auth\Hashing\HashIpb
     */
    private $hasher;

    public function __construct()
    {
        require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
        require_once __DIR__.'/../src/Hashing/HashMybb1.php';
        require_once __DIR__.'/../src/Hashing/HashIpb.php';

        $this->hasher = new \MyBB\Auth\Hashing\HashIpb();
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
