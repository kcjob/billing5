<?php

namespace Apps;

class EquipmentUseDAO
{
  /**
  * Data Access Object
  * Because static methods are callable without an instance of the object created,
  * the pseudo-variable $this is not available inside the method declared as static.
  */

  function __construc()
  {

  }

  static function getEquipmentUseDetails($dbConnection, $invoiceId)
  {
    $allDetails = [];
    $query = "SELECT CII.invoice, CII.details, CII.service_id, CII.total, CI.filename, CI.payer, P.email, concat_ws(' ', P.first_name, P.last_name) AS name
    FROM core_invoice_item AS CII, core_invoice AS CI, people AS P
    WHERE CII.invoice = '$invoiceId' AND CII.invoice = CI.number and P.individual_id = CI.payer";

    $results = $dbConnection->query($query);
    //var_dump($results);
    $useDetailsObject = new EquipmentUseDetails();

    //Create an array of each user as objects
    //Create an array of each user as objects
    while($row = $results -> fetch_assoc()){
      //check whether data is already in object
      if(!$useDetailsObject->userName and $row['name'])
      {
         $useDetailsObject->userName = $row['name'];
         $useDetailsObject->email = $row['email'];

         array_push($useDetailsObject->serviceInfoArray, $useDetailsObject->details = $row['details']); #, $row['total']);
         if(!in_array($row['filename'],
         $useDetailsObject->attachmentArray))
         {
           array_push($useDetailsObject->attachmentArray, $useDetailsObject->fileName = $row['filename']);
         }
         $useDetailsObject->invoiceNumber = $row['invoice'];
         $useDetailsObject->service_id = $row['service_id'];
         $useDetailsObject->total = $row['total'];
      }elseif($useDetailsObject->userName == $row['name']) {
           array_push($useDetailsObject->serviceInfoArray, $useDetailsObject->details = $row['details']);
           if(!in_array($row['filename'],
           $useDetailsObject->attachmentArray))
           {
             array_push($useDetailsObject->attachmentArray, $useDetailsObject->fileName = $row['filename']);
           }
      }
    } //while
    return($useDetailsObject);
  }

}
