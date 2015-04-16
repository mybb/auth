<?php

namespace MyBB\Auth\Exceptions;

class AuthNotMybbInstanceException extends \RuntimeException
{
	protected $message = 'User is not instance of MyBB\\Auth\\Contracts\\UserContract';
}
