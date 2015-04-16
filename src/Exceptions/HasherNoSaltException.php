<?php

namespace MyBB\Auth\Exceptions;

class HasherNoSaltException extends \RuntimeException
{
	protected $message = "This hasher requires a salt to be specified";
}
