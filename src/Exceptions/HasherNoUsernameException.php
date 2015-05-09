<?php
/**
 * Hasher requires a given username
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth\Exceptions;

class HasherNoUsernameException extends \RuntimeException
{
	/**
	 * @var string
	 */
	protected $message = "This hasher requires a username to be specified";
}
