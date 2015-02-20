<?php

class Phpbb31Test extends PHPUnit_Framework_TestCase  {
    private $hash = '$2y$10$IBq.6Nm7TQtQD9hlwOvO5OhfmgaWM7uMldUXDuTC0V8T1Q.tCuQvW';
    private $utf8_hash = '$2y$10$7AeF8MAYfdr9UhQpAXfT1OfrTtMyQj97.VWTn77mbL7uXl.OSkeC2';
    private $password = 'thisismypassword';

    private $hasher;

    public function __construct()
    {
        require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
        require_once __DIR__.'/../src/Hashing/HashPhpbb3.php';

        $this->hasher = new \MyBB\Auth\Hashing\HashPhpbb3();
    }


    public function testHash()
    {
        $this->assertTrue($this->hasher->check('password', $this->hash));
    }

    public function testUtf8Hash()
    {
        $this->assertTrue($this->hasher->check('pässwörd', $this->utf8_hash));
    }

/*    public function testGenerateAndValidate()
    {
        $hash = $this->hasher->make($this->password);

        $this->assertTrue($this->hasher->check($this->password, $hash));
    }*/
}