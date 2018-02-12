<?php
require_once(__DIR__ .'/vendor/autoload.php');

use \Apps\DBConnect;
use \Apps\UserNamesDAO;
use \Apps\EquipmentUseDAO;
use \Apps\EquipmentUseDetails;
use \Apps\EmailMessageGenerator;
use \Apps\EmailMessageSender;
use \Apps\TemplateView;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('bills');
$dbStream = new StreamHandler('data/billing.log', Logger::ERROR);
$log->pushHandler($dbStream);

try {
    $connection = DBConnect::getConnection();
} catch (Exception $e) {
    $log->error($e->getMessage());
    echo "Problem connecting to the database\r\n";
    die();
}

try {
    $userNamesArray = UserNamesDAO::getUserNames($connection);
} catch (Exception $e) {
    $log->error($e->getMessage());
    echo "Problem retrieving names from database\r\n";
    die();
}

$invoiceIdArray = ['A00001','B00001','B00002'];

foreach($invoiceIdArray as $invoiceId){
    try {
        $useDetailsObject = EquipmentUseDAO::getEquipmentUseDetails($connection, $invoiceId);
        //print_r($useDetailsObject);
    } catch (Exception $e) {
        $log->error($e->getMessage());
        echo "Problem retrieving data from database\r\n";
        die();
    }

    try{
        $emailMessage = EmailMessageGenerator::createEmail($useDetailsObject);
    } catch(Exception $e){
        $log->error($e->getMessage());
        echo "Could not generate email message\r\n";
        die();
    }
    try{
         EmailMessageSender::sendEmail($emailMessage);
    } catch(Exception $e){
        $log->error($e->getMessage());
        echo "Could not send email message\r\n";
        die();
    }

}
