<?php
namespace ADT\Rest;

/**
 * @package ADT\Rest
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
class Schema implements ISchema
{

	private $pairs = Array();

	private $columns = Array();

	private $requiredPairs = Array();

	/**
	 * @param Parameters $parameters
	 * @throws Exceptions\MissingParameterException
	 */
	public function validate(Parameters $parameters)
	{

		foreach ($this->requiredPairs as $column => $x)
			if (!isset($parameters[$column]))
				throw new Exceptions\MissingParameterException($column);

	}

	/**
	 * @param Parameters $parameters
	 */
	public function alias(Parameters $parameters)
	{

		foreach ($parameters as $alias => $value)
			if (isset($this->pairs[$alias]) && $column = $this->pairs[$alias])
				$parameters->$column =& $parameters->$alias;

	}

	/**
	 * @return array
	 */
	public function getColumns()
	{
		return $this->columns;
	}

	/**
	 * @param $column
	 * @param null $alias
	 * @param bool $required
	 */
	protected function addPair($column, $alias = null, $required = false)
	{

		if (!isset($alias))
			$alias = $column;

		$this->columns[] = $column;
		$this->pairs[$alias] = $column;

		if ($required)
			$this->requiredPairs[$column] = true;
	}

}
