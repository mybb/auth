<?php
/**
 * Hasher for BCrypt passwords. Default for MyBB 2.0
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Hashing\BcryptHasher;

class HashBcrypt implements HasherContract
{
    /**
     * @var BcryptHasher
     */
    private $hasher;

    /**
     * @param BcryptHasher $hasher
     */
    public function __construct(BcryptHasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * {@inheritdoc}
     */
    public function make($value, array $options = [])
    {
        return $this->hasher->make($value, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function check($value, $hashedValue, array $options = [])
    {
        return $this->hasher->check($value, $hashedValue, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return $this->hasher->needsRehash($hashedValue, $options);
    }
}
