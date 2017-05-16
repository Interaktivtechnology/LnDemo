<?php

namespace app\models\migration;

use Yii;
use app\components\Helper as helper;


/**
 * This is the model class for table "migration_contact".
 *
 * @property string $Id
 * @property string $ID_Type__c
 * @property string $ID_No__c
 * @property string $LastName
 * @property string $MailingStreetAddress
 * @property string $MailingPostalCode
 * @property string $MailingCountry
 * @property string $Email
 * @property string $Phone
 * @property string $MobilePhone
 * @property string $DataSource
 * @property string $SalesforceId
 * @property string $RecordTypeId
 * @property string $CreatedDate
 * @property string $ModifiedDate
 * @property integer $UpdatedCount
 * @property string $AccountId
 *
 * @property MigrationAccount $account
 * @property MigrationIpc[] $migrationIpcs
 */
class MigrationContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'migration_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Id', 'LastName', 'AccountId'], 'required'],
            [['MailingStreetAddress'], 'string'],
            [['CreatedDate', 'ModifiedDate'], 'safe'],
            [['UpdatedCount'], 'integer'],
            [['Id', 'AccountId'], 'string', 'max' => 12],
            [['ID_Type__c', 'Phone', 'MobilePhone'], 'string', 'max' => 32],
            [['ID_No__c'], 'string', 'max' => 20],
            [['LastName', 'MailingCountry', 'Email', 'DataSource'], 'string', 'max' => 255],
            [['MailingPostalCode'], 'string', 'max' => 6],
            [['SalesforceId', 'RecordTypeId'], 'string', 'max' => 18],
            [['AccountId'], 'exist', 'skipOnError' => true, 'targetClass' => MigrationAccount::className(), 'targetAttribute' => ['AccountId' => 'Id']],
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
            'LastName' => Yii::t('app', 'Last Name'),
            'MailingStreetAddress' => Yii::t('app', 'Mailing Street Address'),
            'MailingPostalCode' => Yii::t('app', 'Mailing Postal Code'),
            'MailingCountry' => Yii::t('app', 'Mailing Country'),
            'Email' => Yii::t('app', 'Email'),
            'Phone' => Yii::t('app', 'Phone'),
            'MobilePhone' => Yii::t('app', 'Mobile Phone'),
            'DataSource' => Yii::t('app', 'Data Source'),
            'SalesforceId' => Yii::t('app', 'Salesforce ID'),
            'RecordTypeId' => Yii::t('app', 'Record Type ID'),
            'CreatedDate' => Yii::t('app', 'Created Date'),
            'ModifiedDate' => Yii::t('app', 'Modified Date'),
            'UpdatedCount' => Yii::t('app', 'Updated Count'),
            'AccountId' => Yii::t('app', 'Account ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(MigrationAccount::className(), ['Id' => 'AccountId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMigrationIpcs()
    {
        return $this->hasMany(MigrationIpc::className(), ['ContactId' => 'Id']);
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
        $row = self::find()->select('Id')->orderBy('Id DESC')->Where(['DataSource' => $this->DataSource])->one();

        if(!$row)
            $number = 0;
        else
            $number = (int)substr($row->Id, 4);
        $row = null;

        return strtolower(substr($this->DataSource, 0, 3))."_".sprintf("%06d",$number + 1);
    }


    public static function createContactFromIPC($ipc, $accountId, $rowNumber)
    {
        if(strtoupper($ipc->ID_Type__c) == 'UEN') return null;
        if($ipc->ID_No__c)
            $contact = self::find()->where(["ID_No__c" => $ipc->ID_No__c])->one();
        else
            $contact = self::find()->where(["LastName" => $ipc->Name, "MailingPostalCode" => $ipc->PostalCode])->one();

        if($contact)
            $contact->CreateLog($rowNumber, $ipc);
        $Updated = $contact == null ? 0 : $contact->UpdatedCount + 1;
        $contact = $contact == null ? new self() : $contact;
        $contact->ID_No__c = $ipc->ID_No__c;
        $contact->ID_Type__c = $ipc->ID_Type__c;
        $contact->LastName = $ipc->Name;
        $contact->MailingStreetAddress = $ipc->StreetAddress;
        $contact->MailingPostalCode = $ipc->PostalCode;
        $contact->MailingCountry = $ipc->Country;
        $contact->Email = $ipc->Email__c;
        $contact->Phone = $ipc->Phone;
        $contact->MobilePhone = $ipc->Mobile;
        $contact->DataSource = "IPC";
        $contact->UpdatedCount = $Updated;
        $contact->Id = $Updated == 0 ? $contact->GenerateId() : $contact->Id;
        $contact->AccountId = $accountId;
        $contact->save();
        return $contact;
        
    }


    public static function createContactFromCms($cmsObject, $accountId, $rowNumber)
    {
        $idType = helper::GetSGIdType($cmsObject['id_nos']);
        if($idType == 'UEN') return null;
        if($cmsObject['id_nos'])
            $contact = self::find()->where(["ID_No__c" => $cmsObject['id_nos']])->one();
        else
            $contact = self::find()->where(["LastName" => $cmsObject['fullname'], "MailingPostalCode" => $cmsObject['postal']])->one();

        if($contact == null):
            $contact = new self();
            $contact->DataSource = "CMS";
            $contact->Id = $contact->GenerateId();
            
        else:
            $contact->UpdatedCount += 1;
            $contact->CreateLog($rowNumber, $cmsObject);
        endif;
        $contact->ID_No__c = $cmsObject['id_nos'];
        $contact->ID_Type__c = $idType;
        $contact->LastName = ucwords(strtolower($cmsObject['fullname']));
        $contact->LastName = $contact->LastName == "" ? 'Anonymous' : $contact->LastName;
        $contact->MailingStreetAddress = ucwords(strtolower($cmsObject['address']));
        $contact->MailingPostalCode = $cmsObject['postal'];
        $contact->MailingCountry = $cmsObject['country'];
        $contact->Email = $cmsObject['email'];
        $contact->Phone = !preg_match('/[9|8][0-9]{5,10}/', $cmsObject['contact']) ? $cmsObject['contact'] : null;
        $contact->MobilePhone = preg_match('/[9|8][0-9]{5,10}/', $cmsObject['contact']) ? $cmsObject['contact'] : null;
        $contact->RecordTypeId = Yii::$app->params['RecordTypeIdContact'];
        $contact->AccountId = $accountId;
        $contact->Salutation = $cmsObject['salutation'];
        $contact->DateOfBirth = $cmsObject['dob'];
        $contact->Occupation = $cmsObject['occupation'];
        $contact->Gender = $cmsObject['sex'];
        $contact->MaritalStatus = $cmsObject['sex'];
        $contact->save();
        return $contact;
    }


    public function CreateLog($rowNumber, $row)
    {
        $log = MigrationLog::find()->where(["DataSource" => $this->DataSource, 
            "Object" => "Contact", "RowNumber" => $rowNumber])->one();
        $log = $log == null ? new MigrationLog() : $log;
        $log->Id = strtolower($this->DataSource).'_c_'.$rowNumber;
        
        $log->RowNumber = $rowNumber;
        $log->RowKey = $this->ID_No__c;
        $log->Value = json_encode($row);
        $log->DataSource = $this->DataSource;
        $log->Object = "Contact";
        $log->CreatedDate = date("Y-m-d H:i:s");
        $log->save();
    }
}
