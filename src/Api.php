<?php 
namespace ADT\Rest\Service;

use Nette;
use ADT;

/**
 * @package ADT\RestAPI
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
class Api extends Nette\Object {

  /** @var string Base URL of the API service */
  private $target;

  /** @var string Application signature */
  private $signature;

  /**
   * Initialize api service
   * @param ADT\Rest\Signature $signature
   */
  public function __construct(ADT\Rest\Signature $signature) {
    $this->signature = $signature;
  }

  /**
   * Set API URL 
   * @param string $target 
   * @return void
   */
  public function setTarget($target) {
    $this->target = $target;
  }

  /**
   * Return absolute URL of action
   * @param string $action 
   * @return string
   */
  private function getActionUrl($action) {
    return $this->target . "/" . $action;
  }

  /**
   * Create HTTP request
   * @param string $action 
   * @param string $type (GET, PUT, CREATE, DELETE)
   * @param array $fields 
   * @return stdClass
   */
  private function createRequest($action, $type, $fields = Array()) {    

    $data = "";
    $ch = curl_init($this->getActionUrl($action));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    
    curl_setopt($ch, CURLOPT_POST, $type === "POST");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
    curl_setopt($ch, CURLOPT_HEADER, 1);    

    if(!empty($fields) && $type !== "GET") {
      $data = json_encode($fields);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);            
    }

    $this->signature->setContents($data);

    $headers = $this->signature->createHeaders();
    $headers[] = "Content-Type: application/json";
    $headers[] = "Accept: application/json";
    $headers[] = "Content-Length: " . strlen($data);    

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);    

    $result = curl_exec($ch);   

    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($result, 0, $header_size);
    $body = substr($result, $header_size);

    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $response = new ADT\Rest\Response($body, $header);
    $response->setCode($code);

    return $response;
  }

  /**
   * Executes HTTP GET request
   * @param string $action 
   * @param string $values 
   * @return stdClass
   */
  public function get($action, $values = Array()) {  

    $action = preg_replace("/\?(.+)/", "", $action);

    if(!empty($values))
      $action .= "?" . http_build_query($values);

    return $this->createRequest($action, "GET");
  }

  /**
   * Executes HTTP PUT request
   * @param string $action 
   * @param string $values 
   * @return stdClass
   */
  public function put($action, $values) {
    return $this->createRequest($action, "PUT", $values);
  }

  /**
   * Executes HTTP POST request
   * @param string $action 
   * @param string $values 
   * @return stdClass
   */
  public function post($action, $values) {
    return $this->createRequest($action, "POST", $values);
  }

  /**
   * Executes HTTP DELETE request
   * @param string $action 
   * @return stdClass
   */
  public function delete($action) {
    return $this->createRequest($action, "DELETE");
  }


  /**
   * Returns app signature
   * @return ADT\Rest\Signature
   */
  public function getSignature() {
    return $this->signature;
  }

}