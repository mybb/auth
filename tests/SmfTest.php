<?php

class SmfTest extends PHPUnit_Framework_TestCase  {
    private $hash = 'c73ba2982c55b7ead0e4098a92f722bdb3a3b3d8';
    private $name = 'User';
    private $utf8_hash = 'fb10111f401c01599157efc637c9cd0dd9870ea0';
    private $utf8_name = 'Test';
    private $password = 'thisismypassword';

    private $hasher;

    public function __construct()
    {
        require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
        require_once __DIR__.'/../src/Hashing/HashSmf.php';

        $this->hasher = new \MyBB\Auth\Hashing\HashSmf();
    }


    public function testHash()
    {
        $this->assertTrue($this->hasher->check('password', $this->hash, ['name' => $this->name]));
    }

    public function testUtf8Hash()
    {
        $this->assertTrue($this->hasher->check('pässwörd', $this->utf8_hash, ['name' => $this->utf8_name]));
    }

/*    public function testGenerateAndValidate()
    {
        $hash = $this->hasher->make($this->password, ['name' => $this->name]);

        $this->assertTrue($this->hasher->check($this->password, $hash, ['name' => $this->name]));
    }*/
}