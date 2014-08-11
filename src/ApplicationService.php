<?php
namespace ADT\Rest\Service;

use Nette;
use Nette\Database\Context;

/**
 * @package ADT\RestAPI
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
class Application extends Nette\Object {

  private $database;

  public function __construct(Context $database) {
    $this->database = $database;
  }

  public function getAppCredentials($appId) {
    $app = $this->database->table("applications")
      ->where("ID_APPLICATION", $appId)
      ->fetch();

    if(!$app)
      return false;

    return Array($appId, $app->SECRET);
  }
}