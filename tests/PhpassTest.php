<?php
/**
 * Test phpass Hasher
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

class PhpassTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var string
     */
    private $hash = '$P$BxlUyAJ0Nz3sCU1YLlqjcOdzZ2m2wa1';
    /**
     * @var string
     */
    private $utf8_hash = '$P$B2qcq0GdT9.K18G1vW8sHrMzpbMagb/';
    /**
     * @var string
     */
    private $password = 'thisismypassword';

    /**
     * @var \MyBB\Auth\Hashing\HashPhpass
     */
    private $hasher;

    public function setUp()
    {
        $phpass = new \MyBB\Auth\Hashing\phpass\PasswordHash(8, true);
        $phpass->PasswordHash(8, true);

        $this->hasher = new \MyBB\Auth\Hashing\HashPhpass($phpass);
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
