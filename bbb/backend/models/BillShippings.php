<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bill_shippings".
 *
 * @property int $id
 * @property int $bill_id Bill ID
 * @property int $user_id ผู้จัดส่งสินค้า
 * @property string $file_upload
 * @property string $remark หมายเหตุ
 */
class BillShippings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill_shippings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['bill_id', 'user_id'], 'integer'],
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
            'id' => Yii::t('app', 'ID'),
            'bill_id' => Yii::t('app', 'Bill ID'),
            'user_id' => Yii::t('app', 'ผู้จัดส่งสินค้า'),
            'file_upload' => Yii::t('app', 'File Upload'),
            'remark' => Yii::t('app', 'หมายเหตุ'),
        ];
    }
    public  function getUsers(){
        return @$this->hasOne(\common\modules\user\models\User::className(), ['id' => 'user_id']);
    }
    public  function getProfiles(){
        return @$this->hasOne(\common\modules\user\models\Profile::className(), ['user_id' => 'user_id']);
    }
}
