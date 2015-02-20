<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use RuntimeException;

/**
 * Hasher for legacy SMF passwords, using different algorithms in different versions
 *
 * @package MyBB\Auth
 */
class HashSmf implements HasherContract
{
    public function make($value, array $options = array())
    {
        // TODO
        throw new RuntimeException('SMF\'s hashing algorithm isn\'t yet implemented');
    }

    public function check($value, $hashedValue, array $options = array())
    {
        if(strlen($hashedValue) == 40)
        {
            $is_sha1 = true;
        }
        else
        {
            $is_sha1 = false;
        }

        if($is_sha1 && sha1(strtolower($options['name']).$value) == $hashedValue)
        {
            return true;
        }
        else
        {
            if(crypt($value, substr($value, 0, 2)) == $hashedValue)
            {
                return true;
            }
            else if(strlen($hashedValue) == 32 && $this->md5_hmac($options['name'], $value) == $hashedValue)
            {
                return true;
            }
            else if(strlen($hashedValue) == 32 && md5($value) == $hashedValue)
            {
                return true;
            }
        }

        // While we encode everything in utf8, smf doesn't do so by default so if we have a different utf8 representation of the password we try that too
        if (utf8_decode($value) !== $value)
            return $this->check(utf8_decode($value), $hashedValue, $options);

        return false;
    }

    public function needsRehash($hashedValue, array $options = array())
    {
        return false;
    }

    private function md5_hmac($username, $password)
    {
        if(strlen($username) > 64)
        {
            $username = pack('H*', md5($username));
        }
        $username = str_pad($username, 64, chr(0x00));
        $k_ipad = $username ^ str_repeat(chr(0x36), 64);
        $k_opad = $username ^ str_repeat(chr(0x5c), 64);
        return md5($k_opad.pack('H*', md5($k_ipad.$password)));
    }
}
