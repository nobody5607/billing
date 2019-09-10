<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bill_shop".
 *
 * @property string $id รหัสร้านค้า
 * @property string $name ชื่อร้าน
 * @property string $address ที่อยู่
 * @property string $lat ละติจูด
 * @property string $lng ลองติจูด
 * @property string $remark หมายเหตุ
 */
class BillShop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill_shop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['name', 'address', 'remark'], 'string', 'max' => 100],
            [['lat', 'lng'], 'string', 'max' => 20],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสร้านค้า'),
            'name' => Yii::t('app', 'ชื่อร้าน'),
            'address' => Yii::t('app', 'ที่อยู่'),
            'lat' => Yii::t('app', 'ละติจูด'),
            'lng' => Yii::t('app', 'ลองติจูด'),
            'remark' => Yii::t('app', 'หมายเหตุ'),
        ];
    }
}
