<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Exceptions\HasherNoSaltException;
use RuntimeException;

/**
 * Hasher for legacy WCF 2 passwords, using the following algorithm:
 *
 * <pre>
 * $password = crypt(crypt($password, $salt), $salt);
 * </pre>
 *
 * @package MyBB\Auth
 */
class HashWcf2 implements HasherContract
{
    public function make($value, array $options = array())
    {
        // We need a salt to use wcf2's hashing algorithm - as we don't generate one here we're throwing an error
        if (empty($options['salt'])) {
            throw new HasherNoSaltException;
        }

        return crypt(crypt($value, $options['salt']), $options['salt']);
    }

    public function check($value, $hashedValue, array $options = array())
    {
        $salt = substr($hashedValue, 0, 29);
        return (crypt(crypt($value, $salt), $salt) == $hashedValue);
    }

    public function needsRehash($hashedValue, array $options = array())
    {
        return false;
    }
}
