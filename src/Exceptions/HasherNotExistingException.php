<?php

namespace MyBB\Auth\Exceptions;

class HasherNotExistingException extends \RuntimeException
{
	protected $message = "Hasher ':class' does not exist";

	public function __construct($class, $code = 0, \Exception $previous = null)
	{
		$message = str_replace(':class', $class, $this->message);

		parent::__construct($message, $code, $previous);
	}
}
