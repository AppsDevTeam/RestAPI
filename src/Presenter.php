<?php
namespace ADT\Rest;

use Nette\Application\Request;
use Nette\Application\UI\PresenterComponentReflection;

/**
 * @package ADT\Rest
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
abstract class Presenter extends \Nette\Application\UI\Presenter
{

	/** @var IApiSignature @inject */
	protected $signature;


	protected function startup()
	{
		parent::startup();

		$httpRequest = $this->getHttpRequest();
		$json = json_decode($httpRequest->getRawBody());
		if ($json) {
			$parameters = Parameters::from($json);
			$this->params["parameters"] = $parameters;
		}
	}

	/**
	 * @param Request $request
	 * @return \Nette\Application\IResponse
	 */
	public function run(Request $request)
	{
		return parent::run($request);
	}


	public function injectSignature(IApiSignature $signature)
	{
		$this->signature = $signature;
	}

	/**
	 * @param PresenterComponentReflection|\ReflectionMethod $element
	 * @throws Exceptions\UnauthorizedException
	 */
	public function checkRequirements($element)
	{
		$secured = (array)$element->getAnnotation("Secured");

		if (in_array("signed", $secured, TRUE)) {
			$this->signature->setContents($this->getHttpRequest()->getRawBody());

			if (!$this->signature->isRequestSigned())
				throw new Exceptions\UnauthorizedException();
		}
	}
}