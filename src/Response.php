<?php
namespace ADT\Rest;

use Nette;

/**
 * @package ADT\RestAPI
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
class Response extends Nette\Object
{

	/** @var int */
	private $code = 200;

	/** @var string */
	private $body;

	/** @var null */
	private $header;

	function __construct($body, $header = null)
	{
		$this->body = $body;
		$this->header = $header;
	}


	/**
	 * @param $code
	 * @return mixed
	 */
	public function setCode($code)
	{
		return $this->code = $code;
	}

	/**
	 * @return int
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * @return Nette\Utils\ArrayHash
	 */
	public function getData()
	{
		$body = json_decode($this->body);
		return $this->standardize($body);
	}

	/**
	 * Creates aliases for back-compatibility
	 * @param $response
	 * @return Nette\Utils\ArrayHash
	 */
	protected function standardize($response)
	{

		if (!($response instanceof \stdClass))
			return $response;

		foreach ($response as $key => $value) {
			$lkey = lcfirst($key);

			if ($lkey !== $key)
				$response->$lkey =& $response->$key;
		}

		return (new Nette\Utils\ArrayHash)->from($response);
	}
}