<?php
namespace ADT\Rest;

/**
 * @package ADT\Rest
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
interface IApplicationService
{

	/**
	 * @param $appId
	 * @return string|null
	 */
	function getApplicationSecret($appId);

}