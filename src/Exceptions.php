<?php

namespace ADT\Rest\Exceptions;

/**
 * @package ADT\Rest
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */

class BasicException extends \ErrorException
{

	function getResponse()
	{
		$response = new \StdClass();
		$response->statusCode = $this->getCode();
		$response->statusMessage = $this->getMessage();

		return $response;
	}

}

class BadRequestException extends BasicException
{

	function __construct($action, $code = 400)
	{
		$message = "Bad request, action '$action'";
		parent::__construct($message, $code);
	}

}

class MissingParameterException extends BasicException
{

	function __construct($parameter, $code = 400)
	{
		$message = "Bad request, missing parameter '$parameter'";
		parent::__construct($message, $code);
	}

}

class NotFoundException extends BasicException
{

	function __construct($object, $code = 404)
	{
		$message = "Requested object was not found '$object'";
		parent::__construct($message, $code);
	}


}

class UnauthorizedException extends BasicException
{

	function __construct($code = 401)
	{
		$message = "You are not authorized.";
		parent::__construct($message, $code);
	}


}
