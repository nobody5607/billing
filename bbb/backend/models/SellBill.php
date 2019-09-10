<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sell_bill".
 *
 * @property string $docno เอกสารเลขที่
 * @property string $docdate เอกสารวันที่
 * @property string $doctime เวลา
 * @property string $refdata เอกสารอ้างอิง
 * @property string $refdate เอกสารอ้างอิงวันที่
 * @property string $customerno ลูกหนี้/เจ้าหนี้
 * @property string $customername ชื่อลูกหนี้/เจ้าหนี้
 * @property string $totalprice มูลค่าสินค้า
 * @property string $netprice มูลค่าหลังหักส่วนลด
 */
class SellBill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sell_bill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['docno'], 'required'],
            [['docdate', 'doctime', 'refdate'], 'safe'],
            [['docno', 'customerno'], 'string', 'max' => 50],
            [['refdata'], 'string', 'max' => 255],
            [['customername'], 'string', 'max' => 200],
            [['totalprice', 'netprice'], 'string', 'max' => 20],
            [['docno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'docno' => Yii::t('app', 'เอกสารเลขที่'),
            'docdate' => Yii::t('app', 'เอกสารวันที่'),
            'doctime' => Yii::t('app', 'เวลา'),
            'refdata' => Yii::t('app', 'เอกสารอ้างอิง'),
            'refdate' => Yii::t('app', 'เอกสารอ้างอิงวันที่'),
            'customerno' => Yii::t('app', 'ลูกหนี้/เจ้าหนี้'),
            'customername' => Yii::t('app', 'ชื่อลูกหนี้/เจ้าหนี้'),
            'totalprice' => Yii::t('app', 'มูลค่าสินค้า'),
            'netprice' => Yii::t('app', 'มูลค่าหลังหักส่วนลด'),
        ];
    }
}
