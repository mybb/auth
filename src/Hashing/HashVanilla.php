<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use RuntimeException;

/**
 * Hasher for legacy Vanilla passwords, using PHPass
 *
 * @package MyBB\Auth
 */
class HashVanilla implements HasherContract
{
    public function make($value, array $options = array())
    {
        // TODO
        throw new RuntimeException('PHPass hashing algorithm isn\'t yet implemented');
    }

    public function check($value, $hashedValue, array $options = array())
    {
        if($hashedValue[0] === '_' || $hashedValue[0] === '$')
        {
            $hash = $this->cryptPrivate($value, $hashedValue);
            if ($hash[0] == '*')
            {
                $hash = crypt($value, $hashedValue);
            }
            return $hash == $hashedValue;
        }
        else if($value && $hashedValue !== '*' && ($value === $hashedValue || md5($value) === $hashedValue))
        {
            return true;
        }
        return false;
    }

    public function needsRehash($hashedValue, array $options = array())
    {
        return false;
    }

    private function cryptPrivate($password, $setting)
    {
        $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $output = '*0';
        if (substr($setting, 0, 2) == $output)
            $output = '*1';
        if (substr($setting, 0, 3) != '$P$')
            return $output;
        $count_log2 = strpos($itoa64, $setting[3]);
        if ($count_log2 < 7 || $count_log2 > 30)
            return $output;
        $count = 1 << $count_log2;
        $salt = substr($setting, 4, 8);
        if (strlen($salt) != 8)
            return $output;
        # We're kind of forced to use MD5 here since it's the only
        # cryptographic primitive available in all versions of PHP
        # currently in use.  To implement our own low-level crypto
        # in PHP would result in much worse performance and
        # consequently in lower iteration counts and hashes that are
        # quicker to crack (by non-PHP code).
        if (PHP_VERSION >= '5') {
            $hash = md5($salt . $password, TRUE);
            do {
                $hash = md5($hash . $password, TRUE);
            } while (--$count);
        } else {
            $hash = pack('H*', md5($salt . $password));
            do {
                $hash = pack('H*', md5($hash . $password));
            } while (--$count);
        }
        $output = substr($setting, 0, 12);
        $output .= $this->hashEncode64($hash, 16, $itoa64);
        return $output;
    }

    private function hashEncode64($input, $count, &$itoa64)
    {
        $output = '';
        $i = 0;
        do
        {
            $value = ord($input[$i++]);
            $output .= $itoa64[$value & 0x3f];
            if ($i < $count)
            {
                $value |= ord($input[$i]) << 8;
            }
            $output .= $itoa64[($value >> 6) & 0x3f];
            if ($i++ >= $count)
            {
                break;
            }
            if ($i < $count)
            {
                $value |= ord($input[$i]) << 16;
            }
            $output .= $itoa64[($value >> 12) & 0x3f];
            if ($i++ >= $count)
            {
                break;
            }
            $output .= $itoa64[($value >> 18) & 0x3f];
        }
        while ($i < $count);
        return $output;
    }
}
