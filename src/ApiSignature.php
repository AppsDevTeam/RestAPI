<?php
namespace ADT\Rest;

use Nette\Database\Context;

/**
 * @package ADT\RestAPI
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
class ApiSignature extends Signature implements ISignature, IApiSignature {


  /** @var ADT\Rest\Service\Application */
  private $appService;

  public function __construct(Service\Application $appService) {
    $this->appService = $appService;
  }

  /**
   * Returns application ID from a request header
   * @return type
   */
  public function getApplicationId() {
    $headers = $this->getAllHeaders();   
    
    if(!preg_match("#AppId=(.+)#s", $headers["Authorization"], $match)) 
      return false;    

    return end($match);
  }

  /**
   * Returns user token, if exists
   * @return boolean|string
   */
  public function getUserToken() {
    $headers = $this->getAllHeaders();

    if(!isset($headers["Token"]) || empty($headers["Token"]))
      return false;

    return $headers["Token"];
  }

  /**
   * Checks if the request is signed or not
   * @return boolean
   */
  public function isRequestSigned() {
    $headers = $this->getAllHeaders();    

    if(!isset($headers["Authorization"]))
      return false;

    if(!isset($headers["Signature"]))
      return false;

    if(!($this->appId = $this->getApplicationId()))
      return false;

    $credentials = $this->appService->getAppCredentials($this->appId);

    if(!$credentials)
      return false;

    list($appId, $secret) = $credentials;
    
    $this->secret = $secret;

    $signature = $headers["Signature"];
    $expected = $this->create();

    return $this->compare($signature, $expected);
  }

  /**
   * Compare signatures
   * @param string $a 
   * @param string $b 
   * @return boolean
   */
  public function compare($a, $b) { 

    $length = strlen($a);

    if (!is_string($a) || !is_string($b)) 
      return false; 
    
    if($a !== $b)
      return false;

    $status = 0; 

    for ($i = 0; $i < $length; $i++) { 
        $status |= ord($a[$i]) ^ ord($b[$i]); 
    } 

    return $status === 0; 
  } 

}