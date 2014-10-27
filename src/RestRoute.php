<?php
namespace ADT\Rest;

use Nette\Application\Routers\Route;
use Nette\Http\IRequest;

/**
 * @package ADT\Rest
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
class RestRoute extends Route
{

	const METHOD_GET = 4;
	const METHOD_POST = 8;
	const METHOD_PUT = 16;
	const METHOD_DELETE = 64;
	const RESTFUL = 128;

	protected static $filterTable = [
		"GET" => "get",
		"POST" => "create",
		"PUT" => "update",
		"DELETE" => "delete"
	];

	/**
	 * @param IRequest $httpRequest
	 * @return \Nette\Application\Request|NULL
	 */
	public function match(IRequest $httpRequest)
	{
		$request = parent::match($httpRequest);

		if (!$request)
			return NULL;

		$method = $httpRequest->getMethod();

		if (!in_array($method, array_flip(self::$filterTable)))
			return NULL;

		$parameters = $request->getParameters();
		$parameters["action"] = isset(self::$filterTable[$method]) ? self::$filterTable[$method] : $method;
		$request->setParameters($parameters);

		if (($this->flags & self::METHOD_GET) === self::METHOD_GET && $method !== 'GET')
			return NULL;

		if (($this->flags & self::METHOD_POST) === self::METHOD_POST && $method !== 'POST')
			return NULL;

		if (($this->flags & self::METHOD_PUT) === self::METHOD_PUT && $method !== 'PUT')
			return NULL;

		if (($this->flags & self::METHOD_DELETE) === self::METHOD_DELETE && $method !== 'DELETE')
			return NULL;


		return $request;
	}

}