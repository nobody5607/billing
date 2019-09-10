<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property int $bill_id รหัสบิล
 * @property string $filename ชื่อไฟล์
 * @property string $filepath ที่อยู่ไฟล์
 * @property int $create_at สร้างโดย
 * @property string $create_date สร้างเมื่อ
 * @property int $update_at แก้ไขโดย
 * @property string $update_date แก้ไขเมื่อ
 * @property int $rstat สถานะ
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bill_id', 'create_at', 'update_at', 'rstat'], 'integer'],
            [['create_date', 'update_date','billtype'], 'safe'],
            [['filename', 'filepath'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'bill_id' => Yii::t('backend', 'รหัสบิล'),
            'filename' => Yii::t('backend', 'ชื่อไฟล์'),
            'filepath' => Yii::t('backend', 'ที่อยู่ไฟล์'),
            'create_at' => Yii::t('backend', 'สร้างโดย'),
            'create_date' => Yii::t('backend', 'สร้างเมื่อ'),
            'update_at' => Yii::t('backend', 'แก้ไขโดย'),
            'update_date' => Yii::t('backend', 'แก้ไขเมื่อ'),
            'rstat' => Yii::t('backend', 'สถานะ'),
        ];
    }
    public  function getBillType(){
        return @$this->hasOne(BillType::className(), ['id' => 'billtype']);
    }
}
