<?php 
namespace ADT\Rest;

use Nette;

/**
 * @package ADT\RestAPI
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
class Response extends Nette\Object {

  private $code = 200;

  private $body;

  private $header;

  function __construct($body, $header = null) {
    $this->body = $body;
    $this->header = $header;
  }


  public function setCode($code) {
    return $this->code = $code;
  }

  public function getCode() {
    return $this->code;
  }

  public function getData() {
    $body = json_decode($this->body);
    return $this->standardize($body);
  }

  /**
   * Creates aliases for back-compatibility
   * @param stdClass $response 
   * @return void
   */
  protected function standardize($response) {

    if(!($response instanceof \stdClass))
      return $response;

    foreach($response as $key => $value) {
      $lkey = lcfirst($key);

      if($lkey !== $key)
        $response->$lkey =& $response->$key;
    }

    return (new Nette\Utils\ArrayHash)->from($response);
  }
}