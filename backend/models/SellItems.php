<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sell_items".
 *
 * @property string $docno เอกสารเลขที่
 * @property string $itemcode รหัสสินค้า
 * @property string $itemname ชื่อสินค้า
 * @property string $treasury คลัง
 * @property string $storage พื้นที่เก็บ
 * @property string $unit หน่วยนับ
 * @property string $amount จำนวน
 * @property string $unitprice ราคา
 * @property string $unitdiscount ส่วนลด
 * @property string $totaldiscount มูลค่าส่วนลด
 * @property string $netprice รวมมูลค่า
 * @property string $netvalue มูลค่าสุทธิ
 * @property string $cashier Cashier
 */
class SellItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sell_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['docno', 'itemcode'], 'required'],
            [['docno', 'itemcode'], 'string', 'max' => 50],
            [['itemname'], 'string', 'max' => 200],
            [['treasury', 'storage', 'unit', 'amount', 'unitprice', 'unitdiscount', 'totaldiscount', 'netprice'], 'string', 'max' => 20],
            [['netvalue', 'cashier'], 'string', 'max' => 100],
            [['docno', 'itemcode'], 'unique', 'targetAttribute' => ['docno', 'itemcode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'docno' => Yii::t('app', 'เอกสารเลขที่'),
            'itemcode' => Yii::t('app', 'รหัสสินค้า'),
            'itemname' => Yii::t('app', 'ชื่อสินค้า'),
            'treasury' => Yii::t('app', 'คลัง'),
            'storage' => Yii::t('app', 'พื้นที่เก็บ'),
            'unit' => Yii::t('app', 'หน่วยนับ'),
            'amount' => Yii::t('app', 'จำนวน'),
            'unitprice' => Yii::t('app', 'ราคา'),
            'unitdiscount' => Yii::t('app', 'ส่วนลด'),
            'totaldiscount' => Yii::t('app', 'มูลค่าส่วนลด'),
            'netprice' => Yii::t('app', 'รวมมูลค่า'),
            'netvalue' => Yii::t('app', 'มูลค่าสุทธิ'),
            'cashier' => Yii::t('app', 'Cashier'),
        ];
    }
}
