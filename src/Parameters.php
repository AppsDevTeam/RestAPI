<?php
namespace ADT\Rest;

use Nette\Utils;

/**
 * @package ADT\Rest
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
class Parameters extends Utils\ArrayHash
{

	/** @var ISchema */
	public $__schema;

	public function setValidationSchema(ISchema $schema)
	{

		$this->__schema = $schema;
		$schema->alias($this);
	}

	public function getValues()
	{
		$data = new Utils\ArrayHash();

		$validColumns = $this->__schema->getColumns();

		foreach ($validColumns as $column)
			if (isset($this[$column]))
				$data[$column] = $this[$column];

		return $data;
	}

	public function validate()
	{
		return $this->__schema->validate($this);
	}

}