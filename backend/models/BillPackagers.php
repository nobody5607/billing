<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bill_packagers".
 *
 * @property int $id รหัส
 * @property int $bill_id Bill ID
 * @property int $user_id ผู้จัดสินค้า
 * @property string $file_upload
 * @property string $remark หมายเหตุ
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างเมื่อ
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขเมื่อ
 * @property int $rstat
 */
class BillPackagers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill_packagers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bill_id', 'user_id'], 'required'],
            [['bill_id', 'user_id', 'create_by', 'update_by', 'rstat'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['file_upload'], 'string', 'max' => 255],
            [['remark'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัส'),
            'bill_id' => Yii::t('app', 'รหัสบิล'),
            'user_id' => Yii::t('app', 'ผู้จัดสินค้า'),
            'file_upload' => Yii::t('app', 'File Upload'),
            'remark' => Yii::t('app', 'หมายเหตุ'),
            'create_by' => Yii::t('app', 'สร้างโดย'),
            'create_date' => Yii::t('app', 'สร้างเมื่อ'),
            'update_by' => Yii::t('app', 'แก้ไขโดย'),
            'update_date' => Yii::t('app', 'แก้ไขเมื่อ'),
            'rstat' => Yii::t('app', 'Rstat'),
        ];
    }
    public  function getUsers(){
        return @$this->hasOne(\common\modules\user\models\User::className(), ['id' => 'user_id']);
    }
    public  function getProfiles(){
        return @$this->hasOne(\common\modules\user\models\Profile::className(), ['user_id' => 'user_id']);
    }
}
