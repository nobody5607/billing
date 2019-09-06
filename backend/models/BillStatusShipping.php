<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bill_status_shipping".
 *
 * @property int $id
 * @property string $name สถานะบิล
 * @property int $rstat สถานะ
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างเมื่อ
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขเมื่อ
 */
class BillStatusShipping extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill_status_shipping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rstat', 'create_by', 'update_by'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'สถานะบิล'),
            'rstat' => Yii::t('app', 'สถานะ'),
            'create_by' => Yii::t('app', 'สร้างโดย'),
            'create_date' => Yii::t('app', 'สร้างเมื่อ'),
            'update_by' => Yii::t('app', 'แก้ไขโดย'),
            'update_date' => Yii::t('app', 'แก้ไขเมื่อ'),
        ];
    }
}
