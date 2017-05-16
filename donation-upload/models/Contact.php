<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "Contacts".
 *
 * @property integer $Id
 * @property string $salesforce_id
 * @property integer $Account_id
 * @property string $account_salesforce_id
 * @property string $Email
 * @property string $ID_Type__c
 * @property string $ID_No__c
 * @property string $Address
 * @property string $Postal_Code
 * @property string $AWSStatus
 * @property string $CreatedDate
 * @property string $LastModifiedDate
 *
 * @property Account $account
 * @property DonationTemp3[] $donationTemp3s
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Account_id'], 'required'],
            [['Account_id'], 'integer'],
            [['Address'], 'string'],
            [['CreatedDate', 'LastModifiedDate'], 'safe'],
            [['salesforce_id', 'account_salesforce_id'], 'string', 'max' => 18],
            [['Email', 'AWSStatus'], 'string', 'max' => 45],
            [['ID_Type__c'], 'string', 'max' => 255],
            [['ID_No__c'], 'string', 'max' => 10],
            [['Postal_Code'], 'string', 'max' => 6],
            [['salesforce_id'], 'unique'],
            [['account_salesforce_id'], 'unique'],
            [['Account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['Account_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'salesforce_id' => 'Salesforce ID',
            'Account_id' => 'Account ID',
            'account_salesforce_id' => 'Account Salesforce ID',
            'Email' => 'Email',
            'ID_Type__c' => 'Id  Type  C',
            'ID_No__c' => 'Id  No  C',
            'Address' => 'Address',
            'Postal_Code' => 'Postal  Code',
            'AWSStatus' => 'Awsstatus',
            'CreatedDate' => 'Created Date',
            'LastModifiedDate' => 'Last Modified Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'Account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonationTemp3s()
    {
        return $this->hasMany(DonationTemp3::className(), ['Contacts_Id' => 'Id']);
    }
}
