<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "commissions".
 *
 * @property int $id
 * @property int $bill_id
 * @property int $user_id
 * @property string $driver
 * @property string $status
 * @property string $price
 * @property string $position
 * @property string $create_date
 * @property string $token
 *
 * * @property string $percent_package
 * * @property string $treasury
 * * @property string $factor
 */
class Commissions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'commissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bill_id', 'user_id'], 'integer'],
            [['create_date','percent_package','treasury','factor'], 'safe'],
            [['driver', 'position', 'token'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 10],
            [['price'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bill_id' => Yii::t('app', 'Bill ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'driver' => Yii::t('app', 'Driver'),
            'status' => Yii::t('app', 'Status'),
            'price' => Yii::t('app', 'Price'),
            'position' => Yii::t('app', 'Position'),
            'create_date' => Yii::t('app', 'Create Date'),
            'token' => Yii::t('app', 'Token'),
        ];
    }
}
