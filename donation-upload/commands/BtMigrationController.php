<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\migration\MigrationIpc;
use app\models\migration\MigrationAccount;
use app\models\migration\MigrationContact;
use app\models\migration\MigrationCms;
use app\components\Helper as helper;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BtMigrationController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }


     /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIpcLinkTransform($limit = 100)
    {
    	$db = Yii::$app->getDb();
        $sql = "SELECT * From DonationIPC LIMIT $limit";
        $command = $db->createCommand($sql);
        $result = $command->queryAll();
        $saved = 0;
        $updated = 0;
        $countryList = helper::getAllCountries();
        $i = 1;
        $startTime = microtime(true);
        foreach($result as $row):
            $trx = Yii::$app->db->beginTransaction();
            $ipc = null;

            if((int)$row['Serial No'] != 0):
                $ipc = MigrationIpc::find()->where(['Old_Serial_Number__c' => $row['Serial No']])->one(); 
                if($ipc != null):
                    $ipc->CreateLog($i, $row);
                endif;
            endif;
            
            $ipc = $ipc == null ? new MigrationIpc : $ipc;
            $ipc->ID_Type__c = helper::GetSGIdType($row['ID No']);
            $ipc->ID_No__c = $row['ID No'];
            $ipc->Salutation = $row['Salutation'];
            $ipc->Name = ucwords(strtolower($row['Name']));
            $ipc->StreetAddress = $row['Add 1'].' '.$row['Add 2'].' '.$row['Add 3'];
            foreach($countryList as $country):
                if(preg_match('/('.strtolower($country).')/i', $ipc->StreetAddress)):
                    $ipc->Country = $country;
                else:
                    $ipc->Country = 'Singapore';
                endif;
                $ipc->StreetAddress = preg_replace('/('.strtolower($country).')/i', '', $ipc->StreetAddress);
            endforeach;
            
            $ipc->StreetAddress = ucwords(strtolower($ipc->StreetAddress));
            $ipc->PostalCode = $row['Postal Code'];
            $ipc->Payment_Method__c = $row['Type of Payment'];
            $format = 'dmY';
            $dateReceived = \DateTime::createFromFormat($format, $row['Date of Donation']);
            $ipc->Date_Received__c = $dateReceived->format("Y-m-d");
            $ipc->TransactioN_No__c = $row['Cheque No'];
            preg_match('/(?:\d*\.)?\d+/', $row['Amount'], $amount);
            $ipc->Amount__c = $amount[0];
            $ipc->Old_Serial_Number__c = $row['Serial No'];
            $ipc->Dedication__c = null;
            $ipc->Remarks = $row['Remarks'];
            $ipc->Email__c = $row['Email Address'];
            $ipc->Phone = !preg_match('/[9|8][0-9]{5,10}/', $row['Tel No']) ? $row['Tel No'] : null;
            $ipc->Mobile = preg_match('/[9|8][0-9]{5,10}/', $row['Tel No']) ? $row['Tel No'] : null;

            $recordTypeAccount = Yii::$app->params['RecordTypeIdAccount'];
            $ipc->RecordTypeIdAccount = $ipc->ID_Type__c == 'UEN' ? $recordTypeAccount['Org Donors'] : $recordTypeAccount['Individual Donors'];
            $ipc->RecordTypeIdContact = Yii::$app->params['RecordTypeIdContact'];
            $ipc->ActionLog = json_encode(
                [
                    "Transformed" => date("d-M-Y H:i")
                ],
                JSON_PRETTY_PRINT
            );
            $account = MigrationAccount::createAccountFromIPC($ipc, $i);
            if($account->getErrors()):
                echo "\nError Account at row ".$i."\n";
                print_r($account->getErrors());
                $trx->rollback();
                break;
            endif;


            $contact = MigrationContact::createContactFromIPC($ipc, $account->Id, $i);
            if($contact != null):
                if($contact->getErrors()):
                    echo "\nError Contact at row ".$i."\n";
                    print_r($contact->getErrors());
                    $trx->rollback();
                    break;
                endif;
            endif;

            $ipc->AccountId = $account->Id;
            $ipc->ContactId = $contact != null ? $contact->Id : null;
            $IsNewRecord = $ipc->IsNewRecord;
            if($ipc->save()):
                $trx->commit();
                $saved += $IsNewRecord ? 1 : 0;
                $updated += $IsNewRecord ? 0 : 1;
            else:
                $errors = $ipc->getErrors();
                echo "\nError Donation at row ".$i."\n";
                print_r($errors);
                $trx->rollback();
                break;
            endif;
            $percentage = (int)($i/count($result) * 100);
            if($i % 100 == 0) echo number_format($percentage)."% \t";
            $ipc = null;
            $contact = null;
            $account = null;
            $i++;
        endforeach;

        $endTime = microtime(true);
        $elapsedTime = $endTime - $startTime ;
        $elapsedTime = $elapsedTime == 0 ? 1 : $elapsedTime;

        echo "\nTime Required : ".number_format($elapsedTime, 4)." second(s)";
        echo "\nTime Required Per Record : ".number_format(count($result)/$elapsedTime, 4)." record/second";
        echo "\nRow Saved : ".$saved;
        echo "\nRow Updated : ".$updated. "\n";
    }

    public function actionExportToCsv($year=2010, $purpose='donation' )
    {
        $column =
        [
            'donation' => "account_sf_id, contact_sf_id, ID_Type__c, ID_No__c,Payment_Method__c,Date_Received__c, TransactioN_No__c, Amount__c,Old_Serial_Number__c",
            'account' => "account_sf_id, ID_Type__c, ID_No__c, Name, StreetAddress, PostalCode,Email__c, Phone, Mobile,Country, RecordTypeIdAccount",
            'contact' => "account_sf_id, contact_sf_id, ID_Type__c, ID_No__c, Name, StreetAddress, PostalCode,Email__c, Phone, Mobile,Country,RecordTypeIdContact",
        ];
        $rows = MigrationIpc::find()->select($column[$purpose])->where("Year(Date_Received__c) = ".$year)->all();
        $path = getcwd().'/../temp/'; 
        echo count($rows);
    }


    public function actionAccessTransform($path, $startRow = 1, $endRow = 100)
    {
        $phpexcel = Yii::getAlias("@vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");
        require_once($phpexcel);
        $objPHPExcel = \PHPExcel_IOFactory::load($path);
        $datas = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);

        $i = 0;
        $countryList = helper::getAllCountries();
        $saved = 0;
        $startTime = microtime(true);
        for($i = $startRow; $i < $endRow && $i < count($datas);$i++):
            $row = $datas[$i];
            $trx = Yii::$app->db->beginTransaction();
            $account = MigrationAccount::find()->where(["Name" => trim($row['B']), "BillingPostalCode" => trim($row['G'])])->
                    orWhere(["Name" => trim($row['C']), "BillingPostalCode" => trim($row['G'])])->one();
            
            $updated = $account != null ? ($account->UpdatedCount + 1) : 0;
            if($account)
                $account->CreateLog($i, $row);
            $account = $account == null ? new MigrationAccount() : $account;
            $account->Name = $row['C'] ? trim($row['C']) : trim($row['B']);

            $account->BillingStreetAddress = ucwords(strtolower(trim($row['D']).' '.trim($row['E']).trim($row['F'])));
            foreach($countryList as $country):
                if(preg_match('/('.strtolower($country).')/i', $account->BillingStreetAddress)):
                    $account->BillingCountry = trim($country);
                else:
                    $account->BillingCountry = 'Singapore';
                endif;
                $account->BillingStreetAddress = preg_replace('/('.strtolower($country).')/i', '', $account->BillingStreetAddress);
            endforeach;
            preg_match('/(?:\d*\.)?\d+/', $row['G'], $postcode);
            if(count($postcode) > 0)
                $account->BillingPostalCode = $postcode[0];
            
            $account->UpdatedCount = $updated;
            $recordTypeAccount = Yii::$app->params['RecordTypeIdAccount'];
            $account->RecordTypeId = $row['C'] ? $recordTypeAccount['Org Donors'] : $recordTypeAccount['Individual Donors'];
            $IsNewRecord = $account->IsNewRecord;
            if($account->IsNewRecord):
                $account->DataSource = "ACC";
                $account->ID_No__c = null;
                $account->ID_Type__c = "Other";
                $account->Id = $account->GenerateId();
                $account->SerialNumberRef = $row["A"];
                $saved += $account->save();
            endif;
            

            if(trim($row['B']) != ''):
                $contact = MigrationContact::find()->where(["LastName" => trim($row['B']), "MailingPostalCode" => trim($row['G'])])->one();
                $updated = $contact != null ? ($contact->UpdatedCount + 1) : 0;
                $contact = $contact == null ? new MigrationContact : $contact;
                if($IsNewRecord):
                    $contact->LastName = $row['B'];
                    $contact->MailingStreetAddress =  $account->BillingStreetAddress;
                    $contact->MailingCountry = $account->BillingCountry;
                    $contact->MailingPostalCode = $account->BillingPostalCode;
                    $contact->ID_No__c = $account->ID_No__c;
                    $contact->ID_Type__c = $account->ID_Type__c;
                    $contact->AccountId = $account->Id;
                    $contact->DataSource = "ACC";
                    $contact->UpdatedCount = $updated;
                    $contact->Id = $contact->GenerateId();
                    $contact->RecordTypeId = Yii::$app->params['RecordTypeIdContact'];
                    $contact->save();
                endif;
            endif;

            $trx->commit();
            $account = null;
            $contact = null;
            $trx = null;
       
        $percentage = (int)($i/($endRow - $startRow) * 100);
        if($i % 100 == 0) echo ".";
        $i++;

        endfor;

        $endTime = microtime(true);
        $elapsedTime = $endTime - $startTime ;
        $elapsedTime = $elapsedTime == 0 ? 1 : $elapsedTime;

        echo "\nTime Required : ".number_format($elapsedTime, 4)." second(s)";
        echo "\nTime Required Per Record : ".number_format((count($datas) < $endRow - $startRow ? count($datas) : $endRow - $startRow )/$elapsedTime, 4)." record/second";
        echo "\nRow Saved : ".$saved;
        echo "\nRow Updated : ".$updated. "\n";
    }


    public function actionCmsTransform($limit = 100)
    {
        $db = Yii::$app->getDb();
        $sql = "SELECT * From vw_cms_data where  year(date_receive) = 2015 and month(date_receive) between 10 and 11 ORDER BY  date_receive desc LIMIT $limit;";
        $command = $db->createCommand($sql);
        $result = $command->queryAll();
        $saved = 0;
        $updated = 0;
        $countryList = helper::getAllCountries();
        $i = 1;
        $startTime = microtime(true);
        foreach($result as $row):
            $trx = Yii::$app->db->beginTransaction();
            $account = MigrationAccount::createAccountFromCms($row, $i);
            
            if($account->getErrors()):
                echo "Error Account at row ".($i+1);
                print_r($account->getErrors());
                print_r($row);
                print_r($account->attributes);
                $trx->rollback();
                break;
            endif;
            if(trim($row['fullname']) != "")
                $contact = MigrationContact::createContactFromCms($row, $account->Id, $i);
            if($contact != null):
                if($contact->getErrors()):
                    echo "Error Contact at row ".($i+1);
                    print_r($contact->getErrors());
                    print_r($row);
                    $trx->rollback();
                    break;
                endif;
            endif;

            $donation = MigrationCms::find()->where(["Old_Serial_Number__c" => $row['Old_Serial_Number']])->one();
            if($donation == null):
                $donation = new MigrationCms();
                $donation->id = $donation->GenerateId();
            endif;
            $donation->Donation_Date__c = $row['date_receive'];
            $donation->Donation_Status__c = $row['status'];
            $donation->Old_Serial_Number__c = $row['Old_Serial_Number'];
            $donation->Payment_Method__c = $row['payment_type'];
            $donation->Transaction_No__c = $row['Transaction_No'];
            $donation->Amount__c = $row['amount'];
            $donation->Remarks__c = $row['Remarks'];
            $donation->Campaign_Raw = $row['CategoryName'];
            $donation->Fund_Type__c = $row['Fund_Type__c'];
            $donation->Cleared_Date__c = $row['Cleared_Date__c'];
            $donation->AccountId = $account->Id;
            $donation->ContactId = $contact != null ? $contact->Id : null;
            $IsNewRecord = $donation->IsNewRecord;
            
            if($donation->save()):
                $trx->commit();
                if($IsNewRecord)
                    $saved++;
                else
                    $updated++;
            else:
                $trx->rollback();
                print_r($donation->getErrors());
                break;
            endif;
            $account = null;
            $contact = null;
            $donation = null;
            if($i % 100 == 0)
                echo ".";
            $i++;
        endforeach;
        $endTime = microtime(true);
        $elapsedTime = $endTime - $startTime ;

        echo "\nTime Required : ".number_format($elapsedTime, 4)." second(s)";
        echo "\nTime Required Per Record : ".number_format(count($result)/$elapsedTime, 0)." record/second";
        echo "\nRow Saved : ".$saved;
        echo "\nRow Updated : ".$updated. "\n";
    }



    public function actionUpdateAccount(){
        $sql = "Update migration_account a SET
            DonationAmountAll = (Select Sum(Amount__c) FROM migration_ipc where AccountId = a.Id),
            NumberOfDonationAll = (Select count(Amount__c) FROM migration_ipc where AccountId = a.Id),
            AvgDonationAmtAll = (Select count(Amount__c) FROM migration_ipc where AccountId = a.Id) 
        ";
        $db = Yii::$app->getDb();
        $command = $db->createCommand($sql);
        echo $command->execute()." Rows Affected\n";

    }


    public function actionChangeAccountIpc(){

        $sql = "select distinct a.id id1, b.id id2, a.lastname, b.lastname, a.id_No__c idno1, b.Id_No__c idno2 from migration_contact b inner join migration_contact a on a.lastname = b.lastname 
            and a.mailingpostalcode = b.mailingpostalcode
            where a.id <> b.id and a.id_no__c is not null 
            and a.lastname  not like '%No Name%'
        ;";
        $db = Yii::$app->getDb();
        $command = $db->createCommand($sql);
        $result = $command->queryAll();
        $command = null;
        $i=0;
        foreach($result as $row):
            if($row['idno2'] == null):
                $sql = "Update migration_ipc set 
                    ContactId = '".$row['id1']."'
                    Where ContactId = '".$row['id2']."'
                ";
                $command = $db->createCommand($sql);
                $i += $command->execute();
                $command = null;
                $sql = "Update migration_cms set 
                    ContactId = '".$row['id1']."'
                    Where ContactId = '".$row['id2']."'
                ";
                $command = $db->createCommand($sql);
                $i += $command->execute();
            endif;
        endforeach;
        echo $i." Rows Affected\n";
    }


    public function actionDeleteDuplicateRecord(){
        $sql = "select distinct a.Id, b.id from migration_contact a 
        inner join migration_contact b
        on a.Id_No__c = b.Id_No__c 
        where a.Id <> b.Id and a.Id_No__c is not null and a.Id_No__c <> ''
        and a.DataSource = 'Acc'
         LIMIT 5000;";

        $db = Yii::$app->getDb();
        $command = $db->createCommand($sql);
        $result = $command->queryAll();
        $command = null;
        $i=0;
        foreach($result as $row):
            $sql = "DeLETE FROM migration_contact where id = '".$row['id']."'";
            $command = $db->createCommand($sql);
            $i += $command->execute();
        endforeach;
        echo $i." Rows Affected\n";

    }
    
}
