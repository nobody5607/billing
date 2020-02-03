<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $id
 * @property string $c_id
 * @property string $name
 * @property string $tel
 */
class Customers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {

        return [
            [['c_id','name','tel','type'],'required'],
            [['c_id'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'c_id' => Yii::t('app', 'รหัสพนักงาน'),
            'name' => Yii::t('app', 'ชื่อ-นามสกุล'),
            'tel' => Yii::t('app', 'เบอร์โทรศัพท์'),
            'type' => Yii::t('app', 'ตำแหน่ง'),
        ];
    }

    public static function getCustomerById($id){
        $model = Customers::findOne($id);
        return $model;
    }
}
