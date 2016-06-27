<?php
/**
 * Test MyBB 1 Hasher
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

class Mybb1Test extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $hash = '9bab3ea951024a935075ca5c9ef6d42d';
    /**
     * @var string
     */
    private $salt = '1QI52qWp';
    /**
     * @var string
     */
    private $utf8_hash = '93692cf2eaee0df690031a79b4511df9';
    /**
     * @var string
     */
    private $utf8_salt = 'Emxu7r8j';
    /**
     * @var string
     */
    private $password = 'thisismypassword';

    /**
     * @var \MyBB\Auth\Hashing\HashMybb1
     */
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
