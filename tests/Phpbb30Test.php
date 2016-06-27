<?php
/**
 * Test phpBB 3.0 Hasher
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

class Phpbb30Test extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $hash = '$H$9H.SIOoJJeV84/fEla5e6iD969pzUP1';
    /**
     * @var string
     */
    private $utf8_hash = '$H$91/RaaGT7AdVorKIgiqYSlwY0tQJ88/';
    /**
     * @var string
     */
    private $password = 'thisismypassword';

    /**
     * @var \MyBB\Auth\Hashing\HashPhpbb3
     */
    private $hasher;

    public function __construct()
    {
        require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
        require_once __DIR__.'/../src/Hashing/phpass/PasswordHash.php';
        require_once __DIR__.'/../src/Hashing/HashPhpbb3.php';

        $phpass = new \MyBB\Auth\Hashing\phpass\PasswordHash(8, true);
        $phpass->PasswordHash(8, true);

        $this->hasher = new \MyBB\Auth\Hashing\HashPhpbb3($phpass);
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
        $hash = $this->hasher->make($this->password, ['hasher' => '3.0']);

        $this->assertTrue($this->hasher->check($this->password, $hash));
    }
}
