<?php
/**
 * Test bbPress Hasher
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

class BbpressTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $hash = '$P$BFY.vYwADSzYYTn.eiSaW/E6hxcmGX1';
    /**
     * @var string
     */
    private $utf8_hash = '$P$Bks.1dvVd1JIVmaIpQxJHf2.BTvzrM.';
    /**
     * @var string
     */
    private $password = 'thisismypassword';

    /**
     * @var \MyBB\Auth\Hashing\HashBbpress
     */
    private $hasher;

    public function __construct()
    {
        require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
        require_once __DIR__.'/../src/Hashing/phpass/PasswordHash.php';
        require_once __DIR__.'/../src/Hashing/HashPhpass.php';
        require_once __DIR__.'/../src/Hashing/HashBbpress.php';

        $phpass = new \MyBB\Auth\Hashing\phpass\PasswordHash(8, true);
        $phpass->PasswordHash(8, true);

        $this->hasher = new \MyBB\Auth\Hashing\HashBbpress($phpass);
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
        $hash = $this->hasher->make($this->password);

        $this->assertTrue($this->hasher->check($this->password, $hash));
    }
}
