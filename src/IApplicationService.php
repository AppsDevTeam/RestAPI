<?php
namespace ADT\Rest;

interface IApplicationService
{

	/**
	 * @param $appId
	 * @return string|null
	 */
	function getApplicationSecret($appId);

}