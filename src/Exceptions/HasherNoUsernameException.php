<?php

namespace MyBB\Auth\Exceptions;

class HasherNoUsernameException extends \RuntimeException
{
	protected $message = "This hasher requires a username to be specified";
}
