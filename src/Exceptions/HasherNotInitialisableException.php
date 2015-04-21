<?php

namespace MyBB\Auth\Exceptions;

class HasherNotInitialisableException extends \RuntimeException
{
	/**
	 * @var string
	 */
	protected $message = "Failed to initialise hasher ':class'";

	/**
	 * @param string     $class
	 * @param int        $code
	 * @param \Exception $previous
	 */
	public function __construct($class, $code = 0, \Exception $previous = null)
	{
		$message = str_replace(':class', $class, $this->message);

		parent::__construct($message, $code, $previous);
	}
}
