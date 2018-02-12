<?php

namespace Apps;

class UserNamesDAO
{
  /**
  * Data Access Object
  * Because static methods are callable without an instance of the object created,
  * the pseudo-variable $this is not available inside the method declared as static.
  */
  function __construc()
  {

  }

  static function getUserNames($dbConnection)
  {
    $allNames = [];
    $query = "SELECT concat(P.first_name, ' ', P.last_name) AS name FROM core_invoice_item AS CII, core_invoice AS CI, people AS P WHERE CII.invoice = CI.number and P.individual_id = CI.payer";

    $results = $dbConnection->query($query);
    //print($results->num_rows);

    //Create an array of each user's name
		while($row = $results -> fetch_assoc()){
      if (!in_array($row['name'], $allNames))
      {
        $allNames[] = $row['name'];
      }
		} //end while

		return $allNames;
  }

}
