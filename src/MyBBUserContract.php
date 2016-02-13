<?php
/**
 * MyBB user contract.
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth;

use Illuminate\Contracts\Auth\Authenticatable;


interface MyBBUserContract extends Authenticatable
{
    /**
     * Get the username of the user.
     *
     * @return string
     */
    public function getUserName();

    /**
     * Get the salt for the user.
     *
     * @return string
     */
    public function getSalt();

    /**
     * Get the type of hasher for the user.
     *
     * Defaults to "core", which sues the built in Laravel hasher (Bcrypt).
     *
     * @return string
     */
    public function getHasher();
}