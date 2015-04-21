<?php

namespace MyBB\Auth\Exceptions;

class HasherNoSaltException extends \RuntimeException
{
	/**
	 * @var string
	 */
	protected $message = "This hasher requires a salt to be specified";
}
