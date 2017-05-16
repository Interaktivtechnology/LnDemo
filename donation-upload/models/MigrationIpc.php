<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "migration_ipc".
 *
 * @property integer $id
 * @property string $account_sf_id
 * @property string $contact_sf_id
 * @property string $donation_sf_id
 * @property string $ID_Type__c
 * @property string $ID_No__c
 * @property string $Salutation
 * @property string $Name
 * @property string $StreetAddress
 * @property string $PostalCode
 * @property string $Payment_Method__c
 * @property string $Date_Received__c
 * @property string $TransactioN_No__c
 * @property string $Amount__c
 * @property string $Old_Serial_Number__c
 * @property string $Dedication__c
 * @property string $Remarks
 * @property string $Email__c
 * @property string $Phone
 * @property string $ActionLog
 */
class MigrationIpc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'migration_ipc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StreetAddress', 'Remarks', 'ActionLog'], 'string'],
            [['Date_Received__c'], 'safe'],
            [['Amount__c'], 'number'],
            [['account_sf_id', 'contact_sf_id', 'donation_sf_id'], 'string', 'max' => 18],
            [['ID_Type__c', 'Name', 'Payment_Method__c', 'TransactioN_No__c', 'Dedication__c', 'Email__c'], 'string', 'max' => 255],
            [['ID_No__c', 'Phone'], 'string', 'max' => 32],
            [['Salutation'], 'string', 'max' => 8],
            [['PostalCode'], 'string', 'max' => 6],
            [['Old_Serial_Number__c'], 'string', 'max' => 45],
            [['Email__c'], 'email', 'message' => "Invalid Email"],
            [['Old_Serial_Number__c'], 'unique', 'message' => "Already Inserted"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'account_sf_id' => Yii::t('app', 'Account Sf ID'),
            'contact_sf_id' => Yii::t('app', 'Contact Sf ID'),
            'donation_sf_id' => Yii::t('app', 'Donation Sf ID'),
            'ID_Type__c' => Yii::t('app', 'Id  Type  C'),
            'ID_No__c' => Yii::t('app', 'Id  No  C'),
            'Salutation' => Yii::t('app', 'Salutation'),
            'Name' => Yii::t('app', 'Name'),
            'StreetAddress' => Yii::t('app', 'Street Address'),
            'PostalCode' => Yii::t('app', 'Postal Code'),
            'Payment_Method__c' => Yii::t('app', 'Payment  Method  C'),
            'Date_Received__c' => Yii::t('app', 'Date  Received  C'),
            'TransactioN_No__c' => Yii::t('app', 'Transactio N  No  C'),
            'Amount__c' => Yii::t('app', 'Amount  C'),
            'Old_Serial_Number__c' => Yii::t('app', 'Old  Serial  Number  C'),
            'Dedication__c' => Yii::t('app', 'Dedication  C'),
            'Remarks' => Yii::t('app', 'Remarks'),
            'Email__c' => Yii::t('app', 'Email  C'),
            'Phone' => Yii::t('app', 'Phone'),
            'ActionLog' => Yii::t('app', 'Action Log'),
        ];
    }



}
