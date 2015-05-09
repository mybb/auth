<?php
/**
 * User isn't a mybb based user
 *
 * @author  MyBB Group
 * @version 2.0.0
 * @package mybb/auth
 * @license http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Auth\Exceptions;

class AuthNotMybbInstanceException extends \RuntimeException
{
	/**
	 * @var string
	 */
	protected $message = 'User is not instance of MyBB\\Auth\\Contracts\\UserContract';
}
