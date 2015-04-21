<?php

namespace MyBB\Auth\Exceptions;

class AuthNotMybbInstanceException extends \RuntimeException
{
	/**
	 * @var string
	 */
	protected $message = 'User is not instance of MyBB\\Auth\\Contracts\\UserContract';
}
