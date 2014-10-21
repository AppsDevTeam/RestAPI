<?php
namespace ADT\Rest;

/**
 * @package ADT\RestAPI
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
class Signature implements ISignature
{

	/** @var string Application secret key */
	protected $secret;

	/** @var string Application ID */
	protected $appId;

	/** @var string User token, if logged */
	protected $token;

	/** @var string * */
	protected $contentHash;

	public function __construct($appId = null, $secret = null)
	{
		if (!isset($appId, $secret))
			return;

		$this->secret = $secret;
		$this->appId = $appId;
	}

	/**
	 * Set hashed content to the signature
	 * @param string $contents
	 * @return string
	 */
	public function setContents($contents)
	{
		if (is_scalar($contents))
			return $this->contentHash = sha1($contents);

		return $this->contentHash = $this->appId;
	}

	/**
	 * Creates a signature
	 * @return string
	 */
	public function create()
	{
		return base64_encode(hash_hmac("sha256", $this->contentHash, $this->secret));
	}

	/**
	 * @return array
	 */
	public function createHeaders()
	{
		$headers = Array(
			"Authorization: HMAC-SHA256 AppId={$this->appId}",
			"Signature: " . $this->create()
		);

		if (isset($this->token) && !empty($this->token))
			$headers[] = "Token: " . $this->token;

		return $headers;
	}

	/**
	 * Sets user token
	 * @param string $token
	 * @return void
	 */
	public function setUserToken($token)
	{
		$this->token = $token;
	}

	/**
	 * Returns user token
	 * @return string
	 */
	public function getUserToken()
	{
		return $this->token;
	}


	/**
	 * Returns HTTP headers (compatible with Nginx)
	 * @return Array
	 */
	public function getAllHeaders()
	{

		if (function_exists('getallheaders'))
			return getallheaders();

		$headers = Array();

		foreach ($_SERVER as $name => $value)
			if (substr($name, 0, 5) == 'HTTP_')
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;

		return $headers;
	}

}