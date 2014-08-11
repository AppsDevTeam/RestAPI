<?php
namespace ADT\Rest;

use Nette\Database\Context;

/**
 * @package ADT\RestAPI
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
interface ISignature {

  /**
   * Create a signature
   * @param string $string 
   * @return string
   */
  function create();

  /**
   * Sign request resp. cUrl handle resource
   * @param resource $ch 
   * @return void
   */
  function getAllHeaders();
  
}
  