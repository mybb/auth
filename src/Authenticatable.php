<?php namespace MyBB\Auth;

use Illuminate\Auth\Authenticatable as LaravelAuthenticatable;

trait Authenticatable
{
    use LaravelAuthenticatable;

    /**
     * Get the username for the user
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->name;
    }

    /**
     * Get the salt for the user
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Get the hasher type for the user
     *
     * @return string
     */
    public function getHasher()
    {
        return $this->hasher;
    }
}
