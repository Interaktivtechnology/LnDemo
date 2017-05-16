<?php

namespace app\models\migration;

use Yii;
use app\components\Helper as helper;


/**
 * This is the model class for table "migration_account".
 *
 * @property string $Id
 * @property string $ID_Type__c
 * @property string $ID_No__c
 * @property string $Name
 * @property string $BillingStreetAddress
 * @property string $BillingPostalCode
 * @property string $BillingCountry
 * @property string $Email__c
 * @property string $Phone
 * @property string $DataSource
 * @property string $SalesforceId
 * @property string $RecordTypeId
 * @property string $ImportedDate
 * @property string $CreatedDate
 * @property string $ModifiedDate
 * @property integer $UpdatedCount
 * @property string $DonationAmountCurrFY
 * @property integer $NumberOfDonationCurrFY
 * @property string $AvgDonationAmtCurrFY
 * @property string $DonationAmountAll
 * @property integer $NumberOfDonationAll
 * @property string $AvgDonationAmtAll
 * @property string $SerialNumberRef
 *
 * @property MigrationContact[] $migrationContacts
 * @property MigrationIpc[] $migrationIpcs
 */
class MigrationAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'migration_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Id', 'Name'], 'required'],
            [['BillingStreetAddress'], 'string'],
            [['ImportedDate', 'CreatedDate', 'ModifiedDate'], 'safe'],
            [['UpdatedCount', 'NumberOfDonationCurrFY', 'NumberOfDonationAll'], 'integer'],
            [['DonationAmountCurrFY', 'AvgDonationAmtCurrFY', 'DonationAmountAll', 'AvgDonationAmtAll'], 'number'],
            [['Id'], 'string', 'max' => 12],
            [['ID_Type__c'], 'string', 'max' => 32],
            [['ID_No__c', 'SerialNumberRef'], 'string', 'max' => 20],
            [['Name', 'BillingCountry', 'Email__c', 'Phone'], 'string', 'max' => 255],
            [['BillingPostalCode'], 'string', 'max' => 6],
            [['DataSource'], 'string', 'max' => 15],
            [['SalesforceId', 'RecordTypeId'], 'string', 'max' => 18],
            [['SalesforceId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'ID_Type__c' => Yii::t('app', 'Id  Type  C'),
            'ID_No__c' => Yii::t('app', 'Id  No  C'),
            'Name' => Yii::t('app', 'Name'),
            'BillingStreetAddress' => Yii::t('app', 'Billing Street Address'),
            'BillingPostalCode' => Yii::t('app', 'Billing Postal Code'),
            'BillingCountry' => Yii::t('app', 'Billing Country'),
            'Email__c' => Yii::t('app', 'Email  C'),
            'Phone' => Yii::t('app', 'Phone'),
            'DataSource' => Yii::t('app', 'Data Source'),
            'SalesforceId' => Yii::t('app', 'Salesforce ID'),
            'RecordTypeId' => Yii::t('app', 'Record Type ID'),
            'ImportedDate' => Yii::t('app', 'Imported Date'),
            'CreatedDate' => Yii::t('app', 'Created Date'),
            'ModifiedDate' => Yii::t('app', 'Modified Date'),
            'UpdatedCount' => Yii::t('app', 'Updated Count'),
            'DonationAmountCurrFY' => Yii::t('app', 'Donation Amount Curr Fy'),
            'NumberOfDonationCurrFY' => Yii::t('app', 'Number Of Donation Curr Fy'),
            'AvgDonationAmtCurrFY' => Yii::t('app', 'Avg Donation Amt Curr Fy'),
            'DonationAmountAll' => Yii::t('app', 'Donation Amount All'),
            'NumberOfDonationAll' => Yii::t('app', 'Number Of Donation All'),
            'AvgDonationAmtAll' => Yii::t('app', 'Avg Donation Amt All'),
            'SerialNumberRef' => Yii::t('app', 'Serial Number Ref'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMigrationContacts()
    {
        return $this->hasMany(MigrationContact::className(), ['AccountId' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMigrationIpcs()
    {
        return $this->hasMany(MigrationIpc::className(), ['AccountId' => 'Id']);
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) 
        {
            
            $this->CreatedDate = date("Y-m-d H:i:s");
            $this->ModifiedDate = $this->IsNewRecord ? date("Y-m-d H:i:s") : $this->ModifiedDate;
            return true;
        } else {
            return false;
        }
    }

    public function GenerateId()
    {
        $row = self::find()->select('Id')->Where(['DataSource' => $this->DataSource])->orderBy('Id DESC')->one();

        if(!$row)
            $number = 0;
        else{
            $number = (int)substr($row->Id, 4);
        }
        
        $row = null;

        return strtolower(substr($this->DataSource, 0, 3))."_".sprintf("%06d",$number + 1);
    }

    public static function createAccountFromIPC($ipcObject, $rowNumber)
    {

        if($ipcObject->ID_No__c)
            $account = self::find()->where(["ID_No__c" => $ipcObject->ID_No__c])->one();
        else
            $account = self::find()->where(["Name" => $ipcObject->Name, "BillingPostalCode" => $ipcObject->PostalCode])->one();
        
        $updated = $account != null ? ($account->UpdatedCount + 1) : 0;
        if($account)
            $account->CreateLog($rowNumber, $ipcObject);

        $account = $account == null ? new MigrationAccount() : $account;
        
        $account->Name = $ipcObject->Name;
        $account->ID_No__c = empty($ipcObject->ID_No__c) ? $account->ID_No__c : $ipcObject->ID_No__c;
        $account->ID_Type__c = $ipcObject->ID_Type__c;
        $account->BillingStreetAddress = empty($ipcObject->StreetAddress) ? $account->BillingStreetAddress : $ipcObject->StreetAddress ;
        $account->BillingCountry = $ipcObject->Country;
        $account->BillingPostalCode = empty($ipcObject->PostalCode) ? $account->BillingPostalCode : $ipcObject->PostalCode;
        $account->Email__c = $ipcObject->Email__c;
        $account->Phone = $ipcObject->Phone ? $ipcObject->Phone  : $ipcObject->Mobile;
        $account->DataSource = "IPC";
        $account->UpdatedCount = $updated;
        $account->SerialNumberRef = $ipcObject->Old_Serial_Number__c;

        $account->Id = $updated === 0 ? $account->GenerateId() : $account->Id;

        $account->save();
        return $account;
    }


    public static function createAccountFromCms($cmsObject, $rowNumber)
    {
        $fullname = trim($cmsObject['fullname']) != "" ? ucwords(strtolower($cmsObject['fullname'])) : "Anonymous";

        if($cmsObject['id_nos'])
            $account = self::find()->where(["ID_No__c" => $cmsObject['id_nos']])->one();
        else
            $account = self::find()->where(["Name" => $fullname, "BillingPostalCode" => $cmsObject['postal']])->one();
        if($account == null):
            $account = new self();
            $account->DataSource = "CMS";
            $account->Id = $account->GenerateId();
        else:
            $updated = $account == null ? 1 : $account->UpdatedCount;
            $account->CreateLog($rowNumber, $cmsObject);
        endif;
        
        

        $account->Name = ucwords(strtolower($fullname));

        $account->ID_No__c = $cmsObject['id_nos'];
        $account->ID_Type__c = helper::GetSGIdType($cmsObject['id_nos']);
        $account->BillingStreetAddress = $cmsObject['address'];

        $account->BillingCountry = $cmsObject['country'];
        $account->BillingPostalCode = $cmsObject['postal'];
        $account->Email__c = $cmsObject['email'];
        $recordTypeAccount = Yii::$app->params['RecordTypeIdAccount'];
        $account->RecordTypeId = $account->ID_Type__c == "UEN" ? $recordTypeAccount['Org Donors'] : $recordTypeAccount['Individual Donors'];

        $account->Phone = $cmsObject['contact'];
        $account->SerialNumberRef = $cmsObject['donor_id'];
        $account->save();
        return $account;
    }


    public function CreateLog($rowNumber, $row)
    {
        $log = MigrationLog::find()->where(["DataSource" => $this->DataSource, "RowNumber" => $rowNumber, "Object" => "Account"])->one();
        $log = $log == null ? new MigrationLog() : $log;
        $log->Id = strtolower($this->DataSource).'_a_'.$rowNumber;
        $log->RowNumber = $rowNumber;
        $log->RowKey = $this->ID_No__c;
        $log->Value = json_encode($row);
        $log->DataSource = $this->DataSource;
        $log->Object = "Account";
        $log->CreatedDate = date("Y-m-d H:i:s");
        $log->save();
    }
}
