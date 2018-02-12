<?php
namespace Apps;

class DBConnect {
  /**
  * Creates a connection object
  *
  */

  static function getConnection()
  {
    /**
    * Get database conenction info via an .ini file
    * return database object
    */
    $db_params = parse_ini_file("config/config.ini");
    $dbconnect = \mysqli_connect($db_params['hostname'], $db_params['dbusr'], $db_params['dbpwrd'], $db_params['dbname']);
    if (!$dbconnect) {
      throw new \Exception('Could not connect: ' . mysqli_connect_error());
    }
    return $dbconnect;
  } //getConnect function
}
