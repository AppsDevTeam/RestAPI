<?php
namespace ADT\Rest;

/**
 * @package ADT\RestAPI
 * @author  Vojtěch Studenka | AppsDevTeam.com
 */
interface IApiSignature {

  /**
   * Checks if the request is correctly signed
   * @return boolean
   */
  function isRequestSigned();

  /**
   * Compares two signatures
   * @param string $a 
   * @param string $b 
   * @return boolean
   */
  function compare($a, $b);
}