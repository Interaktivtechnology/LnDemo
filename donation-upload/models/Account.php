<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Account".
 *
 * @property integer $id
 * @property string $salesforce_id
 * @property string $FirstName
 * @property string $LastName
 * @property string $AccountNumber
 * @property string $Site
 * @property string $AccountSource
 * @property string $AnnualRevenue
 * @property string $BillingAddress
 * @property string $Description
 * @property string $Phone
 * @property string $Rating
 * @property string $Account_Rating__c
 * @property string $Avg_Donation_Amt_Curr_FY__c
 * @property string $Email__c
 * @property string $ID_No__c
 * @property string $ID_Type__c
 * @property string $Type_of_Donor__c
 * @property string $CreatedDate
 * @property string $LastModifiedDate
 * @property integer $AWSStatus
 *
 * @property Contacts[] $contacts
 * @property DonationTemp3[] $donationTemp3s
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Avg_Donation_Amt_Curr_FY__c'], 'number'],
            [['CreatedDate', 'LastModifiedDate'], 'safe'],
            [['AWSStatus'], 'integer'],
            [['salesforce_id'], 'string', 'max' => 18],
            [['FirstName', 'LastName', 'AccountNumber', 'Site', 'AccountSource', 'AnnualRevenue', 'BillingAddress', 'Description', 'Account_Rating__c'], 'string', 'max' => 255],
            [['Phone', 'Rating', 'ID_Type__c'], 'string', 'max' => 32],
            [['Email__c', 'Type_of_Donor__c'], 'string', 'max' => 45],
            [['ID_No__c'], 'string', 'max' => 10],
            [['salesforce_id'], 'unique'],
            [['ID_No__c'], 'unique', 'message' => 'ID no already exists'],
            [['ID_No__c'], 'validateIdNo'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'salesforce_id' => 'Salesforce ID',
            'FirstName' => 'First Name',
            'LastName' => 'Last Name',
            'AccountNumber' => 'Account Number',
            'Site' => 'Site',
            'AccountSource' => 'Account Source',
            'AnnualRevenue' => 'Annual Revenue',
            'BillingAddress' => 'Billing Address',
            'Description' => 'Description',
            'Phone' => 'Phone',
            'Rating' => 'Rating',
            'Account_Rating__c' => 'Account  Rating  C',
            'Avg_Donation_Amt_Curr_FY__c' => 'Avg  Donation  Amt  Curr  Fy  C',
            'Email__c' => 'Email  C',
            'ID_No__c' => 'Id  No  C',
            'ID_Type__c' => 'Id  Type  C',
            'Type_of_Donor__c' => 'Type Of  Donor  C',
            'CreatedDate' => 'Created Date',
            'LastModifiedDate' => 'Last Modified Date',
            'AWSStatus' => 'Awsstatus',
            'data_source' => 'Data Source'
        ];
    }

    public function validateIdNo($attribute, $params)
    {
       $nric_pattern =  '/([S|T]{1}[0-9]{7}[a-zA-Z]{1})/';
        $status[0] = preg_match($nric_pattern,$this->ID_No__c);
        if($status[0])
            $this->ID_Type__c = 'NRIC';

        $uen_pattern = '/([0-9]{8}[a-zA-Z]{1})/';
        $uen_pattern2 = '/([T][0-9]{2}[a-zA-Z]{2}[0-9]{4}[a-zA-Z]{1})/';
        $status[1] = preg_match($uen_pattern, $this->ID_No__c) || preg_match($uen_pattern2, $this->ID_No__c);
        if($status[1])
            $this->ID_Type__c = 'UEN';

        $status[2] =  preg_match('/([G|F]{1}[0-9]{7}[a-zA-Z]{1})/', $this->ID_No__c);
        if($status[2])
            $this->ID_Type__c = "FIN";

        $valid = false;
        foreach($status as $is_valid):
            $valid = $is_valid || $valid;
        endforeach;

        if(!$valid):
            //$this->addError($attribute, 'ID is not valid');
            $this->ID_Type__c = "Other";
        endif;
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contacts::className(), ['Account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonationTemp3s()
    {
        return $this->hasMany(DonationTemp3::className(), ['Account_id' => 'id']);
    }
}
