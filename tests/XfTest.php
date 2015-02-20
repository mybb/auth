<?php

class XfTest extends PHPUnit_Framework_TestCase  {
    private $hash = '$2a$10$DfcgH9Z99.JMXN4kk33nQeKk2bI4/8jdN4HsDQt/J4Qc8T8MHtjV2';
    private $utf8_hash = '$2a$10$1L8KDRVa49bG7fwxPDxr1eLqGVRNW1OXrPthKgLbejfMf14xHXEna';
    private $password = 'thisismypassword';

    private $hasher;

    public function __construct()
    {
        require_once __DIR__.'/../vendor/illuminate/contracts/Hashing/Hasher.php';
        require_once __DIR__.'/../src/Hashing/HashXf12.php';

        $this->hasher = new \MyBB\Auth\Hashing\HashXf12();
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