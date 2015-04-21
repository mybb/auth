<?php

namespace MyBB\Auth\Exceptions;

class HasherNoUsernameException extends \RuntimeException
{
	/**
	 * @var string
	 */
	protected $message = "This hasher requires a username to be specified";
}
