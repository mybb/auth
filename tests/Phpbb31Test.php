<?php
/**
 * Test phpBB 3.1 Hasher
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

class Phpbb31Test extends \PHPUnit\Framework\TestCase
{
    /**
     * @var string
     */
    private $hash = '$2y$10$IBq.6Nm7TQtQD9hlwOvO5OhfmgaWM7uMldUXDuTC0V8T1Q.tCuQvW';
    /**
     * @var string
     */
    private $utf8_hash = '$2y$10$7AeF8MAYfdr9UhQpAXfT1OfrTtMyQj97.VWTn77mbL7uXl.OSkeC2';
    /**
     * @var string
     */
    private $password = 'thisismypassword';

    /**
     * @var \MyBB\Auth\Hashing\HashPhpbb3
     */
    private $hasher;

    public function setUp()
    {
        $phpass = new \MyBB\Auth\Hashing\phpass\PasswordHash(8, true);
        $phpass->PasswordHash(8, true);

        $this->hasher = new \MyBB\Auth\Hashing\HashPhpbb3($phpass);
    }

    public function testHash()
    {
        $this->assertTrue($this->hasher->check('password', $this->hash, ['hasher' => '3.1']));
    }

    public function testUtf8Hash()
    {
        $this->assertTrue($this->hasher->check('pässwörd', $this->utf8_hash, ['hasher' => '3.1']));
    }

    public function testGenerateAndValidate()
    {
        $hash = $this->hasher->make($this->password);

        $this->assertTrue($this->hasher->check($this->password, $hash, ['hasher' => '3.1']));
    }
}
