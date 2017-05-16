<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "mcp_verification".
 *
 * @property integer $id
 * @property string $reference
 * @property string $trx_date
 * @property string $auth_code
 * @property string $amount
 * @property integer $donation_id
 * @property string $response_message
 * @property string $card_no
 * @property string $payer_name
 * @property string $created_date
 * @property string $last_modified_date
 * @property string $salesforce_id
 */
class McpVerification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mcp_verification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'donation_id'], 'integer'],
            [['trx_date', 'created_date', 'last_modified_date'], 'safe'],
            [['amount'], 'number'],
            [['reference'], 'unique', 'message' => 'Transaction ID "'.$this->reference.'" exist in database.'],
            [['reference', 'payer_name'], 'string', 'max' => 255],
            [['auth_code'], 'string', 'max' => 16],
            [['response_message'], 'string', 'max' => 15],
            [['card_no'], 'string', 'max' => 128],
            [['salesforce_id'], 'string', 'max' => 18],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'reference' => Yii::t('app', 'Reference'),
            'trx_date' => Yii::t('app', 'Trx Date'),
            'auth_code' => Yii::t('app', 'Auth Code'),
            'amount' => Yii::t('app', 'Amount'),
            'donation_id' => Yii::t('app', 'Donation ID'),
            'response_message' => Yii::t('app', 'Response Message'),
            'card_no' => Yii::t('app', 'Card No'),
            'payer_name' => Yii::t('app', 'Payer Name'),
            'created_date' => Yii::t('app', 'Created Date'),
            'last_modified_date' => Yii::t('app', 'Last Modified Date'),
            'salesforce_id' => Yii::t('app', 'Salesforce ID'),
        ];
    }

    public function search($params)
    {
        $query = self::find();

        // add conditions that should always apply here
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['salesforce_id' => SORT_ASC, 'last_modified_date'=>SORT_DESC]]
        ]);

        $this->attributes = $params;

        $query->andFilterWhere(['=', 'salesforce_id', $this->salesforce_id])
            
            ->andFilterWhere(['like', 'reference', $this->reference])
            ->andFilterWhere(['like', 'auth_code', $this->auth_code])
            ->andFilterWhere(['>=', 'amount', $this->amount])
            ->andFilterWhere(['like', 'payer_name', $this->payer_name])
            ;            
        return $dataProvider;
        
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) 
        {
            $this->created_date = date("Y-m-d H:i:s");
            $this->last_modified_date = date("Y-m-d H:i:s");

            $row = DonationTemp::find()->where(['reference' => $this->reference])->one();
            if($this->salesforce_id)
                $row = $row == null ? DonationTemp::find()->where(['salesforce_id' => $this->salesforce_id])->one() : $row;
            if($row)
                $this->donation_id = $row->id;
            return true;
        } else {
            return false;
        }
    }
}
