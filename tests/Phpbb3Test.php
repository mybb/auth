<?php

class Phpbb3Test extends PHPUnit_Framework_TestCase  {
    private $hash = '$H$9H.SIOoJJeV84/fEla5e6iD969pzUP1';
    private $utf8_hash = '$H$91/RaaGT7AdVorKIgiqYSlwY0tQJ88/';
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