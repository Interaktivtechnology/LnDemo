<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "donation_temp3".
 *
 * @property integer $id
 * @property string $payment_type
 * @property string $date_received
 * @property string $reference
 * @property string $remarks
 * @property double $amount
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
 */
class Donation extends \yii\db\ActiveRecord
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
            [['payment_type', 'date_received', 'reference', 'remarks', 'amount', 'tax_deductable', 'salutation', 'name', 'id_type', 'id_no', 'email', 'address', 'postcode', 'channel', 'event_name', 'charity_name', 'phone', 'trx_id'], 'required'],
            [['date_received', 'imported_date'], 'safe'],
            [['amount'], 'number'],
            [['payment_type', 'remarks', 'name', 'id_no', 'address', 'event_name', 'charity_name'], 'string', 'max' => 255],
            [['reference', 'tax_deductable', 'id_type', 'email', 'channel', 'phone', 'trx_id'], 'string', 'max' => 45],
            [['salutation'], 'string', 'max' => 10],
            [['postcode'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_type' => 'Payment Type',
            'date_received' => 'Date Received',
            'reference' => 'Reference',
            'remarks' => 'Remarks',
            'amount' => 'Amount',
            'tax_deductable' => 'Tax Deductable',
            'salutation' => 'Salutation',
            'name' => 'Name',
            'id_type' => 'Id Type',
            'id_no' => 'Id No',
            'email' => 'Email',
            'address' => 'Address',
            'postcode' => 'Postcode',
            'channel' => 'Channel',
            'imported_date' => 'Imported Date',
            'event_name' => 'Event Name',
            'charity_name' => 'Charity Name',
            'phone' => 'Phone',
            'trx_id' => 'Trx ID',
        ];
    }

   
}

