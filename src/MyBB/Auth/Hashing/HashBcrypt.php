<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Hashing\BcryptHasher;

class HashBcrypt implements HasherContract
{
    /** @var BcryptHasher $hasher */
    private $hasher;


    public function __construct(BcryptHasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * This is only a wrapper to use Laravel's Bcrypt hasher. Used like this to avoid special checks in the factory
     */
    public function make($value, array $options = array())
    {
        return $this->hasher->make($value, $options);
    }

    public function check($value, $hashedValue, array $options = array())
    {
        return $this->hasher->check($value, $hashedValue, $options);
    }

    public function needsRehash($hashedValue, array $options = array())
    {
        return $this->hasher->needsRehash($hashedValue, $options);
    }
}
