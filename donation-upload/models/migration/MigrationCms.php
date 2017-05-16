<?php

namespace app\models\migration;

use Yii;

/**
 * This is the model class for table "migration_cms".
 *
 * @property string $id
 * @property string $Donation_Date__c
 * @property string $Old_Serial_Number__c
 * @property string $Payment_Method__c
 * @property string $Transaction_No__c
 * @property string $Amount__c
 * @property string $Donation_Status__c
 * @property string $Remarks__c
 * @property string $Campaign_Raw
 * @property string $Campaign__c
 * @property string $Fund_Type__c
 * @property string $Cleared_Date__c
 * @property string $AccountId
 * @property string $ContactId
 *
 * @property MigrationAccount $account
 * @property MigrationContact $contact
 */
class MigrationCms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'migration_cms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['Donation_Date__c', 'Cleared_Date__c'], 'safe'],
            [['Amount__c'], 'number'],
            [['Remarks__c'], 'string'],
            [['id', 'Campaign__c'], 'string', 'max' => 18],
            [['Old_Serial_Number__c', 'Fund_Type__c'], 'string', 'max' => 45],
            [['Payment_Method__c'], 'string', 'max' => 32],
            [['Transaction_No__c'], 'string', 'max' => 64],
            [['Donation_Status__c', 'Campaign_Raw'], 'string', 'max' => 255],
            [['AccountId', 'ContactId'], 'string', 'max' => 12],
            [['AccountId'], 'exist', 'skipOnError' => true, 'targetClass' => MigrationAccount::className(), 'targetAttribute' => ['AccountId' => 'Id']],
            [['ContactId'], 'exist', 'skipOnError' => true, 'targetClass' => MigrationContact::className(), 'targetAttribute' => ['ContactId' => 'Id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'Donation_Date__c' => Yii::t('app', 'Donation  Date  C'),
            'Old_Serial_Number__c' => Yii::t('app', 'Old  Serial  Number  C'),
            'Payment_Method__c' => Yii::t('app', 'Payment  Method  C'),
            'Transaction_No__c' => Yii::t('app', 'Transaction  No  C'),
            'Amount__c' => Yii::t('app', 'Amount  C'),
            'Donation_Status__c' => Yii::t('app', 'Donation  Status  C'),
            'Remarks__c' => Yii::t('app', 'Remarks  C'),
            'Campaign_Raw' => Yii::t('app', 'Campaign  Raw'),
            'Campaign__c' => Yii::t('app', 'Campaign  C'),
            'Fund_Type__c' => Yii::t('app', 'Fund  Type  C'),
            'Cleared_Date__c' => Yii::t('app', 'Cleared  Date  C'),
            'AccountId' => Yii::t('app', 'Account ID'),
            'ContactId' => Yii::t('app', 'Contact ID'),
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
    public function getContact()
    {
        return $this->hasOne(MigrationContact::className(), ['Id' => 'ContactId']);
    }


    public function GenerateId()
    {
        $row = self::find()->select('id')->orderBy('Id DESC')->one();
        
        if(!$row)
            $number = 0;
        else
            $number = (int)substr($row->id, 4);
        $row = null;

        return "cms_".sprintf("%06d",$number + 1);
    }
}
