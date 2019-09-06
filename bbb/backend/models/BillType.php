<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bill_type".
 *
 * @property int $id
 * @property string $name ประเภทบิล
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างเมื่อ
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขเมื่อ
 * @property int $rstat สถานะ
 */
class BillType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['create_by', 'update_by', 'rstat'], 'integer'],
            [['create_date', 'update_date','type'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'name' => Yii::t('backend', 'ประเภทบิล'),
            'create_by' => Yii::t('backend', 'สร้างโดย'),
            'create_date' => Yii::t('backend', 'สร้างเมื่อ'),
            'update_by' => Yii::t('backend', 'แก้ไขโดย'),
            'update_date' => Yii::t('backend', 'แก้ไขเมื่อ'),
            'rstat' => Yii::t('backend', 'สถานะ'),
            'type'=> Yii::t('backend', 'ประเภท'),
        ];
    }
}
