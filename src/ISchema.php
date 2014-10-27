<?php
namespace ADT\Rest;

/**
 * @package ADT\Rest
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
interface ISchema
{
	function validate(Parameters $parameters);

	function alias(Parameters $parameters);

	function getColumns();
}
