<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "donation_temp3".
 *
 * @property integer $id
 * @property string $salesforce_id
 * @property string $payment_type
 * @property string $date_received
 * @property string $reference
 * @property string $remarks
 * @property string $amount
 * @property string $tax_deductable
 * @property string $salutation
 * @property string $name
 * @property string $id_type
 * @property string $id_no
 * @property string $email
 * @property string $address
 * @property string $postcode
 * @property string $channel
 * @property string $imported_date
 * @property string $event_name
 * @property string $charity_name
 * @property string $phone
 * @property string $trx_id
 * @property integer $sf_upload
 * @property string $created_date
 * @property string $last_modified_date
 * @property integer $Account_id
 * @property integer $Contacts_Id
 * @property string $Bank__c
 * @property string $Cheque_No__c
 * @property string $Cheque_Bank__c
 * @property string $Status__c
 *
 * @property Account $account
 * @property Contact $contacts
 */
class DonationTemp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'donation_temp3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_type', 'date_received', 'channel',], 'required'],
            [['date_received', 'payment_type', 'id', 'amount','data_source', 'event_name'], 'safe'],
            [['amount', 'fees', 'gross'], 'number'],
            [['sf_upload', 'Account_id', 'Contacts_Id'], 'integer'],
            [['salesforce_id'], 'string', 'max' => 18],
            [['payment_type', 'remarks', 'name', 'id_no', 'address', 'event_name', 'charity_name', 'Bank__c'], 'string', 'max' => 255],
            [['reference', 'tax_deductable', 'id_type', 'email', 'channel'], 'string', 'max' => 45],
            [['salutation'], 'string', 'max' => 10],
            [['postcode'], 'string', 'max' => 6],
            [['phone'], 'string', 'max' => 32],
            [['email'], 'email', 'message'=>'Invalid Email'],
            [['trx_id', 'Cheque_No__c', 'Cheque_Bank__c', 'Status__c'], 'string', 'max' => 128],
            [['salesforce_id'], 'unique'],
            [['id_no'], 'validateIdNo'],
            [['postcode'], 'validatePostalCode'],
            [['reference'], 'validateReference'],
            //[['date_received'], 'date'],
            [['Account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['Account_id' => 'id']],
            [['Contacts_Id'], 'exist', 'skipOnError' => true, 'targetClass' => Contact::className(), 'targetAttribute' => ['Contacts_Id' => 'Id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'salesforce_id' => Yii::t('app', 'Salesforce ID'),
            'payment_type' => Yii::t('app', 'Payment Type'),
            'date_received' => Yii::t('app', 'Date Received'),
            'reference' => Yii::t('app', 'Transaction No / Reference'),
            'remarks' => Yii::t('app', 'Remarks'),
            'amount' => Yii::t('app', 'Amount'),
            'tax_deductable' => Yii::t('app', 'Tax Deductable'),
            'salutation' => Yii::t('app', 'Salutation'),
            'name' => Yii::t('app', 'Name'),
            'id_type' => Yii::t('app', 'Id Type'),
            'id_no' => Yii::t('app', 'Id No'),
            'email' => Yii::t('app', 'Email'),
            'address' => Yii::t('app', 'Address'),
            'postcode' => Yii::t('app', 'Postcode'),
            'channel' => Yii::t('app', 'Channel'),
            'imported_date' => Yii::t('app', 'Imported Date'),
            'event_name' => Yii::t('app', 'Event Name'),
            'charity_name' => Yii::t('app', 'Charity Name'),
            'phone' => Yii::t('app', 'Phone'),
            'trx_id' => Yii::t('app', 'Trx ID'),
            'sf_upload' => Yii::t('app', 'Sf Upload'),
            'created_date' => Yii::t('app', 'Created Date'),
            'last_modified_date' => Yii::t('app', 'Last Modified Date'),
            'Account_id' => Yii::t('app', 'Account ID'),
            'Contacts_Id' => Yii::t('app', 'Contacts  ID'),
            'Bank__c' => Yii::t('app', 'Bank '),
            'Cheque_No__c' => Yii::t('app', 'Cheque  No '),
            'Cheque_Bank__c' => Yii::t('app', 'Cheque  Bank'),
            'Status__c' => Yii::t('app', 'Status'),
        ];
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) 
        {
            $this->name = ucwords(strtolower($this->name));
            if($this->id_type == 'NRIC')
            $this->valid_nric = \app\components\Helper::validateNRIC($this->id_no);
            $this->created_date = date("Y-m-d H:i:s");
            $this->last_modified_date = date("Y-m-d H:i:s");
            return true;
        } else {
            return false;
        }
    }


    public function validateReference($attribute, $params)
    {
        $row = self::find()->where(["reference" => $this->reference, "channel" => $this->channel])->one();

        if($row != null && $this->isNewRecord)
            $this->addError($attribute, "Transaction No has been inserted for this channel (".$this->channel.")");
    }

    public function validateIdNo($attribute, $params)
    {
        $nric_pattern =  '/([S|T]{1}[0-9]{7}[a-zA-Z]{1})/';
        $status[0] = preg_match($nric_pattern,$this->id_no);
        if($status[0])
            $this->id_type = 'NRIC';

        $uen_pattern = '/([0-9]{8}[a-zA-Z]{1})/';
        $uen_pattern2 = '/[T][0-9]{2}[a-zA-Z]{2}[0-9]{4}[a-zA-Z]{1}/';
        $status[1] = preg_match($uen_pattern, $this->id_no) || preg_match($uen_pattern2, $this->id_no);
        if($status[1])
            $this->id_type = 'UEN';

        $status[2] =  preg_match('/([G|F]{1}[0-9]{7}[a-zA-Z]{1})/', $this->id_no);
        if($status[2])
            $this->id_type = "FIN";

        $valid = false;
        foreach($status as $is_valid):
            $valid = $is_valid || $valid;
        endforeach;

        if(!$valid):
            //$this->addError($attribute, 'ID is not valid');
            $this->id_type = "Other";
        endif;

    }

    public function validatePostalCode($attributes, $params){
        $pattern = "/[0-9]{5,6}/";

        if(!preg_match($pattern, $this->postcode)){
            $this->addError($attributes, 'Postal code is not valid');
        }

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
    public function getContacts()
    {
        return $this->hasOne(Contact::className(), ['Id' => 'Contacts_Id']);
    }

    public function search($params)
    {
        $query = self::find();

        // add conditions that should always apply here
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['sf_upload' => SORT_ASC, 'last_modified_date'=>SORT_DESC, 'date_received' => SORT_DESC]]
        ]);

        $this->attributes = $params;

        $query->andFilterWhere(['=', 'id', $this->id])
            ->andFilterWhere(['=', 'payment_type', $this->payment_type])
            ->andFilterWhere(['=', 'sf_upload', $this->sf_upload])
            ->andFilterWhere(['like', 'event_name', $this->event_name])
            ->andFilterWhere(['like', 'channel', $this->channel])
            ->andFilterWhere(['>=', 'amount', $this->amount])
            ->andFilterWhere(['like', 'date_received', $this->date_received])
            ->andFilterWhere(['like', 'name', $this->name])
            ;

            
        return $dataProvider;
        
    }

    public function getDistinctPaymentType(){
        $db = Yii::$app->db;

        $sql = "SELECT DISTINCT payment_type from donation_temp3";
        $q = $db->createCommand($sql);
        $result = $q->queryAll();
        $newResult = [];
        for($i=0; $i<count($result);$i++):
            $newResult[$result[$i]['payment_type']] = $result[$i]['payment_type'];
        endfor;

        return $newResult;
    }
    public static function migrateFromCms()
    {
        $dbCms = Yii::$app->db2;
        $sql = "SELECT date_receive, payment_type, cheque_no, cheque_bank, 
            amount, status, remarks, ipc, date_create, date_update, date_bank,
            c.name as category_name, type_donation, type_donation_name, receipt_no, date_clear, 
            fullname, calling_name, contact as phoneNumber, address, email,
            salutation, address2, address3, postal, name1, name2, id_nos, id_type,
            country,
            organization_address,
            organization_address2


            FROM boystown.donation a inner join `profile` b
            on a.donor_id = b.id 
            inner join donation_categories c on a.category = c.id

            where 
            is_donor = 1 and date_void is null LIMIT 100";
        $q = $dbCms->createCommand($sql);
        $result = $q->queryAll();
        $i = 0;
        foreach($result as $row):
            $i++;
            $name = explode(' ', $row['fullname']);
            $account = Account::find()->where(["ID_No__c" => $row['id_nos']])
            ->andWhere(['NOT',['ID_No__c' => null]])
            ->andWhere(['NOT' , ['ID_No__c' => '']])
            //->andWhere(['Like', 'FirstName', $name[0]])
            ->one();
            
            $account = $account == null ? new Account : $account;
            $account->Type_of_Donor__c = $account->isNewRecord ? 'One-Time' : 'Recuring';
            $trx = $account->getDb()->beginTransaction();
            $account->FirstName = $row['fullname'];
            $account->LastName = $row['calling_name'];
            $account->AccountNumber = null;
            $account->AccountSource = 'MySQLCMS';
            $account->Email__c = $row['email'];
            $account->Phone = $row['phoneNumber'];
            $account->ID_No__c = $row['id_nos'];
            $account->Description = $row['remarks'];
            $account->LastModifiedDate = date("Y-m-d H:i:s");
            $account->BillingAddress = $row['address'];
            $account->Rating = '3';
            if(!$account->save()):
                echo "Error row ".$i.json_encode($account->getErrors(), JSON_PRETTY_PRINT)."\n";
                $trx->rollback();
                continue;
            endif;
            if($account->ID_Type__c == 'NRIC'):
                $contact = Contact::find()->where(["ID_No__c" => $row['id_nos']])
                ->andWhere(['NOT',['ID_No__c' => null]])
                ->andWhere(['NOT' , ['ID_No__c' => '']])->one();

                $contact = $contact == null ? new Contact : $contact;

                $contact->Account_id = $account->id;
                $contact->Email = $row['Email'];
                $contact->ID_No__c = $row['id_nos'];
                $contact->ID_Type__c = $account->ID_Type__c;
                $contact->Address = $row['address'];
                $contact->CreatedDate = date("Y-m-d H:i:s");
                $contact->LastModifiedDate = date("Y-m-d H:i:s");
                $contact->save();
            endif;

            $donation = new DonationTemp();

            $donation->payment_type = $row['payment_type'];
            $donation->date_received = $row['date_receive'];
            $donation->reference = $row['cheque_no'];
            $donation->remarks = $row['remarks'];
            $donation->amount = $row['amount'];
            $donation->tax_deductable = (string)($row['id_nos'] != null);
            $donation->salutation = $row['salutation'];
            $donation->name = $row['fullname'];
            $donation->id_type = $account->ID_Type__c;
            $donation->id_no = $account->ID_No__c;
            $donation->email = $row['email'];
            $donation->channel = 'MysqlCMS';
            $donation->imported_date = null;
            $donation->event_name = $row['category_name'];
            $donation->created_date = date("Y-m-d H:i:s");
            $donation->last_modified_date = date("Y-m-d H:i:s");
            $donation->trx_id = $row['cheque_no'] != null ? $row['cheque_no'] : '';
            $donation->Account_id = $account->id;
            $donation->Contacts_Id = $contacts->id;
            $donation->Bank__c = $row["bank"];
            $donation->Cheque_No__c = $row['cheque_no'];
            $donation->Status__c = $row['status'];
            $donation->data_source = 'MysqlCMS';
            $donation->date_cleared = $row['date_clear'];
            $donation->postcode = $row['postal'];
            $donation->reference = $row['cheque_no'];
            $donation->charity_name = $row['category_name'];
            $donation->remarks = $row['remarks'];
            if(!$donation->save()):
                echo 'Row '.$i.' '.json_encode($donation->getErrors(), JSON_PRETTY_PRINT)."<br />";
                $trx->rollback();
                continue;
            endif;
            $trx->commit();
            
        endforeach;
    }



    public static function createAccount($donation){
        // Account Creation
        $account = Account::find()->where(["ID_No__c" => $donation->id_no])
        ->andWhere(['NOT',['ID_No__c' => null]])
        ->andWhere(['NOT' , ['ID_No__c' => '']])
        //->andWhere(['Like', 'FirstName', $name[0]])
        ->one();
        $account = $account == null ? new Account : $account;
        $account->Type_of_Donor__c = $account->isNewRecord ? 'One-Time' : 'Recuring';
        $account->FirstName = $donation->name;
        $account->AccountNumber = null;
        $account->AccountSource = 'BT Website';
        $account->Email__c = $donation->email;
        $account->Phone = (string)$donation->phone;
        $account->ID_No__c = $donation->id_no;
        $account->ID_Type__c = $donation->id_type;
        $account->Description = $donation->remarks;
        $account->LastModifiedDate = date("Y-m-d H:i:s");
        $account->BillingAddress = $donation->address;
        $account->Rating = '3';
        return $account;
    }
}
