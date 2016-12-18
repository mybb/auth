<?php
/**
 * Test SMF 2.1 Hasher
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

class Smf21Test extends \PHPUnit\Framework\TestCase
{
    /**
     * @var string
     */
    private $hash = '$2y$13$HxdgIIWdxd6HSl8.5BCS8urINNi/HHN9sbwQ57TEJj5R0j25iK1W6';
    /**
     * @var string
     */
    private $name = 'User';
    /**
     * @var string
     */
    private $utf8_hash = '$2y$13$/MdC5inL/yBg3DGprSLiQuZo3PPxWy5OuKE4EH2ffMcVbu4DZnuxK';
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

    public function setUp()
    {
        $this->hasher = new \MyBB\Auth\Hashing\HashSmf();
    }

    public function testHash()
    {
        $this->assertTrue($this->hasher->check('password', $this->hash, ['name' => $this->name, 'hasher' => '2.1']));
    }

    public function testUtf8Hash()
    {
        $this->assertTrue(
            $this->hasher->check('pässwörd', $this->utf8_hash, ['name' => $this->utf8_name, 'hasher' => '2.1'])
        );
    }

    public function testGenerateAndValidate()
    {
        $hash = $this->hasher->make($this->password, ['name' => $this->name, 'hasher' => '2.1']);

        $this->assertTrue($this->hasher->check($this->password, $hash, ['name' => $this->name, 'hasher' => '2.1']));
    }
}
