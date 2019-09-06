<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bill_chargers".
 *
 * @property int $id
 * @property int $bill_id Bill ID
 * @property int $user_id พนักงานเก็บเงิน
 * @property string $amount จำนวนเงิน
 * @property string $file_upload
 * @property string $remark หมายเหตุ
 * @property int $rstat
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างเมื่อ
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขเมือ
 */
class BillChargers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill_chargers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bill_id', 'user_id'], 'required'],
            [['bill_id', 'user_id', 'rstat', 'create_by', 'update_by'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['amount', 'file_upload'], 'string', 'max' => 255],
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
            'user_id' => Yii::t('app', 'พนักงานเก็บเงิน'),
            'amount' => Yii::t('app', 'จำนวนเงิน'),
            'file_upload' => Yii::t('app', 'File Upload'),
            'remark' => Yii::t('app', 'หมายเหตุ'),
            'rstat' => Yii::t('app', 'Rstat'),
            'create_by' => Yii::t('app', 'สร้างโดย'),
            'create_date' => Yii::t('app', 'สร้างเมื่อ'),
            'update_by' => Yii::t('app', 'แก้ไขโดย'),
            'update_date' => Yii::t('app', 'แก้ไขเมือ'),
        ];
    }
    public  function getUsers(){
        return @$this->hasOne(\common\modules\user\models\User::className(), ['id' => 'user_id']);
    }
    public  function getProfiles(){
        return @$this->hasOne(\common\modules\user\models\Profile::className(), ['user_id' => 'user_id']);
    }
}
