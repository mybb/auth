<?php
/**
 * Hasher for legacy Vanilla passwords, using PHPass
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth\Hashing;

class HashVanilla extends HashPhpass
{
    /**
     * {@inheritdoc}
     */
    public function check($value, $hashedValue, array $options = [])
    {
        if ($hashedValue[0] === '_' || $hashedValue[0] === '$') {
            return parent::check($value, $hashedValue, $options);
        } elseif ($value && $hashedValue !== '*' && ($value === $hashedValue || md5($value) === $hashedValue)) {
            return true;
        }

        return false;
    }
}
