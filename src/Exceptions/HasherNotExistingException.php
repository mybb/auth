<?php

namespace MyBB\Auth\Exceptions;

class HasherNotExistingException extends \RuntimeException
{
	/**
	 * @var string
	 */
	protected $message = "Hasher ':class' does not exist";

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
