<?php
namespace Apps;

class EmailMessageSender {
  static function sendEmail($emailMessage) {
    $emailParams = parse_ini_file("config/config.ini");

    // Create the Transport
    $transport = (new \Swift_SmtpTransport('outgoing.ccny.cuny.edu', 587, 'tls'))
    -> setUsername($emailParams['userName'])
    -> setPassword($emailParams['userPassword']);
    $mailer = new \Swift_Mailer($transport);

    // create and register logger
    $sentEmaillogger = new \Swift_Plugins_Loggers_ArrayLogger();
    $mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin($sentEmaillogger));

    //echo $emailMessage->toString();

    // Send the message
    $mailer->send($emailMessage, $failures);

    // output log
    file_put_contents('data/sentEmails.log', $sentEmaillogger->dump());
  }
}
