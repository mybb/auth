<?php

namespace MyBB\Auth\Contracts;

use Illuminate\Contracts\Auth\Authenticatable as LaravelUserContract;

interface UserContract extends LaravelUserContract
{
    /**
     * Get the username for the user
     *
     * @return string
     */
    public function getUsername();

    /**
     * Get the salt for the user
     *
     * @return string
     */
    public function getSalt();

    /**
     * Get the hasher type for the user
     *
     * @return string
     */
    public function getHasher();
}
