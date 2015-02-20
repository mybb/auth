<?php

class IpbTest extends PHPUnit_Framework_TestCase  {
    private $hash = '7e6f3724d991b5b7c96411abfcb7928c';
    private $salt = 'GN53]';
    private $utf8_hash = 'b794917b289e73dbe67d90c02c501173';
    private $utf8_salt = '2$![1';
    private $password = 'thisismypassword';

    private $hasher;

    public function __construct()
    {
        require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
        require_once __DIR__.'/../src/Hashing/HashMybb1.php';
        require_once __DIR__.'/../src/Hashing/HashIpb.php';

        $mybb = new \MyBB\Auth\Hashing\HashMybb1();
        $this->hasher = new \MyBB\Auth\Hashing\HashIpb($mybb);
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