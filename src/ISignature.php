<?php
namespace ADT\Rest;

/**
 * @package ADT\RestAPI
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
interface ISignature
{

	/**
	 * Create a signature
	 * @return string
	 */
	function create();

	/**
	 * Return all headers
	 * @return void
	 */
	function getAllHeaders();

}
