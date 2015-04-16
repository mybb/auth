<?php namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use MyBB\Auth\Exceptions\HasherNotExistingException;
use MyBB\Auth\Exceptions\HasherNotInitialisableException;
use RuntimeException;

class HashFactory implements HasherContract
{
    /** @var Application $app */
    private $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function make($value, array $options = array())
    {
        $hasher = $this->getHasher($options['type']);

        return $hasher->make($value, $options);
    }

    public function check($value, $hashedValue, array $options = array())
    {
        $hasher = $this->getHasher($options['type']);

        return $hasher->check($value, $hashedValue, $options);
    }

    public function needsRehash($hashedValue, array $options = array())
    {
        $hasher = $this->getHasher($options['type']);

        return $hasher->needsRehash($hashedValue, $options);
    }

    /**
     * Get's the actual hashing class for a specified hashing type
     *
     * @param string $hashName The name of the hashing class we should use.
     *
     * @return HasherContract The created hasher.
     */
    protected function getHasher($hashName = 'bcrypt')
    {
        if(empty($hashName))
        {
            $hashName = 'bcrypt';
        }

        $hasherClass = 'MyBB\\Auth\\Hashing\\Hash' . ucfirst($hashName);

        // Invalid hashing type
        if (!class_exists($hasherClass)) {
            throw new HasherNotExistingException($hasherClass);
        }

        $hasher = $this->app->make($hasherClass);

        if (!$hasher || !($hasher instanceof HasherContract)) {
            throw new HasherNotInitialisableException($hasherClass);
        }

        return $hasher;
    }
}
