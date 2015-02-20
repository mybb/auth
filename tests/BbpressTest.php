<?php

class BbpressTest extends PHPUnit_Framework_TestCase  {
    private $hash = '$P$BFY.vYwADSzYYTn.eiSaW/E6hxcmGX1';
    private $utf8_hash = '$P$Bks.1dvVd1JIVmaIpQxJHf2.BTvzrM.';
    private $password = 'thisismypassword';

    private $hasher;

    public function __construct()
    {
        require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
        require_once __DIR__.'/../src/Hashing/HashBbpress.php';

        $this->hasher = new \MyBB\Auth\Hashing\HashBbpress();
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