<?php
namespace Apps;

class EmailMessageGenerator
{
  static function createEmail($billObject){
    $emailParams = parse_ini_file("config/config.ini");

    $app = new TemplateView();
    $msg = $app->generateView($billObject);

        // Create a message
    $message = (new \Swift_Message('Core Facilities Equipment Billings'))
      -> setFrom($emailParams['fromName'])
      -> setTo($emailParams['sentTo']) //($msgDataObject->userEmailAddress);
      -> setContentType("text/html")
      -> setBody($msg);

    if(!empty($billObject->attachmentArray)){
      foreach($billObject->attachmentArray as $document){
          $attachment = \Swift_Attachment::fromPath('data/' . $document);
          $message -> attach($attachment);
      }
    }
    return $message;
  }
}
