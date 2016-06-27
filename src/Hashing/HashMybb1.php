<?php
/**
 * Hasher for legacy MyBB 1.x passwords, using the following algorithm:
 *
 * <pre>
 * $password = md5(md5($salt) . md5($password));
 * </pre>
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Exceptions\HasherNoSaltException;

class HashMybb1 implements HasherContract
{
    /**
     * {@inheritdoc}
     */
    public function make($value, array $options = [])
    {
        // We need a salt to use mybb 1.x hashing algorithm - as we don't generate one here we're throwing an error
        if (empty($options['salt'])) {
            throw new HasherNoSaltException();
        }

        return md5(md5($options['salt']) . md5($value));
    }

    /**
     * {@inheritdoc}
     */
    public function check($value, $hashedValue, array $options = [])
    {
        return ($hashedValue == $this->make($value, $options));
    }

    /**
     * {@inheritdoc}
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
}
