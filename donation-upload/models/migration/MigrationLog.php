<?php

namespace app\models\migration;

use Yii;

/**
 * This is the model class for table "migration_log".
 *
 * @property integer $RowNumber
 * @property string $RowKey
 * @property string $Value
 * @property string $DataSource
 * @property string $CreatedDate
 */
class MigrationLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'migration_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['RowNumber', 'CreatedDate'], 'required'],
            [['RowNumber'], 'integer'],
            [['Value'], 'string'],
            [['CreatedDate'], 'safe'],
            [['RowKey', 'DataSource'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'RowNumber' => Yii::t('app', 'Row Number'),
            'RowKey' => Yii::t('app', 'Row Key'),
            'Value' => Yii::t('app', 'Value'),
            'DataSource' => Yii::t('app', 'Data Source'),
            'CreatedDate' => Yii::t('app', 'Created Date'),
        ];
    }
}
