<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use RuntimeException;

/**
 * Hasher for legacy MyBB 1.x passwords, using the following algorithm:
 *
 * <pre>
 * $password = md5(md5($salt) . md5($password));
 * </pre>
 *
 * @package MyBB\Auth
 */
class HashMybb1 implements HasherContract
{
    public function make($value, array $options = array())
    {
        // We need a salt to use mybb 1.x hashing algorithm - as we don't generate one here we're throwing an error
        if (empty($options['salt'])) {
            throw new RuntimeException("No salt specified");
        }

        return md5(md5($options['salt']) . md5($value));
    }

    public function check($value, $hashedValue, array $options = array())
    {
        return ($hashedValue == $this->make($value, $options));
    }

    public function needsRehash($hashedValue, array $options = array())
    {
        return false;
    }
}
