<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use RuntimeException;

/**
 * Hasher for legacy XenForo passwords, using some sort of PHPass -> to be confirmed
 *
 * @package MyBB\Auth
 */
class HashXf12 implements HasherContract
{
    public function make($value, array $options = array())
    {
        // TODO
        throw new RuntimeException('PHPass hashing algorithm isn\'t yet implemented');
    }

    public function check($value, $hashedValue, array $options = array())
    {
        if ($hashedValue == crypt($value, $hashedValue))
        {
            return true;
        }

        return false;
    }

    public function needsRehash($hashedValue, array $options = array())
    {
        return false;
    }
}
