<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bill_rc".
 *
 * @property int $id
 * @property string $billdate วันที่ออกบิล
 * @property string $billref เลขที่บิล
 * @property string $customer_id รหัสลูกหนี้
 * @property string $customer_name ชื่อลูกหนี้
 * @property string $amount จำนวนเงิน
 * @property string $balance ยอดคงเหลือ
 * @property string $pamount ยอดชำระ
 * @property string $bill_date เอกสารวันที่
 * @property string $doc_num เอกสารเลขที่
 * @property string $cashier พนักงานขาย
 * @property int $rstat สถานะ
 * @property int $create_by สร้างโดย
 * @property string $create_date สร้างเมื่อ
 * @property int $update_by แก้ไขโดย
 * @property string $update_date แก้ไขเมื่อ
 */
class BillRc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill_rc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['billdate', 'customer_id', 'doc_num'], 'string'],
            [['bill_date', 'create_date', 'update_date'], 'safe'],
            [['rstat', 'create_by', 'update_by'], 'integer'],
            [['billref', 'customer_name', 'amount', 'balance', 'pamount', 'cashier'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'billdate' => Yii::t('app', 'วันที่ออกบิล'),
            'billref' => Yii::t('app', 'เลขที่บิล'),
            'customer_id' => Yii::t('app', 'รหัสลูกหนี้'),
            'customer_name' => Yii::t('app', 'ชื่อลูกหนี้'),
            'amount' => Yii::t('app', 'จำนวนเงิน'),
            'balance' => Yii::t('app', 'ยอดคงเหลือ'),
            'pamount' => Yii::t('app', 'ยอดชำระ'),
            'bill_date' => Yii::t('app', 'เอกสารวันที่'),
            'doc_num' => Yii::t('app', 'เอกสารเลขที่'),
            'cashier' => Yii::t('app', 'พนักงานขาย'),
            'rstat' => Yii::t('app', 'สถานะ'),
            'create_by' => Yii::t('app', 'สร้างโดย'),
            'create_date' => Yii::t('app', 'สร้างเมื่อ'),
            'update_by' => Yii::t('app', 'แก้ไขโดย'),
            'update_date' => Yii::t('app', 'แก้ไขเมื่อ'),
        ];
    }
}
