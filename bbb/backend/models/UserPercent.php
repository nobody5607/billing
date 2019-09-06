<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_percent".
 *
 * @property int $bill_id
 * @property string $driver คนขับ
 * @property string $customer ลูกน้อง
 * @property int $default
 */
class UserPercent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_percent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bill_id'], 'required'],
            [['bill_id', 'default'], 'integer'],
            [['driver', 'customer'], 'string', 'max' => 5],
            [['bill_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bill_id' => Yii::t('app', 'Bill ID'),
            'driver' => Yii::t('app', 'คนขับ %'),
            'customer' => Yii::t('app', 'ลูกน้อง %'),
            'default' => Yii::t('app', 'Default'),
        ];
    }
}
