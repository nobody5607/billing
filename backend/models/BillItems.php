<?php

namespace backend\models;

use Yii;

/** 
 * This is the model class for table "bill_items".
 *
 * @property string $id Bill ID
 * @property string $bookno บิลเล่มที่ (Ref to next record)
 * @property int $billno หมายเลขบิล (Auto Number)
 * @property string $billref CR/CRV/CRA
 * @property string $shop_id
 * @property int $btype 1 = บิลลูกค้าฟ้า 2=บิลบัญชีแดง
 * @property string $amount จำนวนเงิน
 * @property int $status สถานะบิล 0=ปกติ 1=ชำรุดเสียหาย 2=ยกเลิก
 * @property int $shiping สถานะการส่งสินค้า 0=ยังไม่จัดสินค้า 1=จัดสินค้าแล้ว 2=ออกไปส่งสินค้าแล้ว 3=
 * @property int $charge สถานะเก็บเงิน 0=ยังไม่เรียกเก็บ 1=วางบิล 2=ฝากเก็บเงิน 3=เก็บเงิน/เช็ค/โอน 4=ตัดบัญชีแล้ว
 * @property string $bill_upload
 * @property string $remark หมายเหตุ
 */
class BillItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['billno', 'status','amount','blog','bill_type','billref','bill_date'], 'required'],
            [['id',  'billno', 'shop_id', 'btype', 'status', 'charge','affective_score'], 'integer'],
            [['bookno','amount'], 'string', 'max' => 20],
            [['remark'], 'string', 'max' => 100],
            [['rstat'], 'required'],
            [['create_date','update_date','rstat','create_by','update_by','billtype','bill_date','bill_type','shiping','billref','blog','difficulty'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Bill ID'),
            'bookno' => Yii::t('app', 'บิลเล่มที่'),
            'billno' => Yii::t('app', 'หมายเลขบิล'),
            'billref' => Yii::t('app', 'ชื่อบิล'),//CR/CRV/CRA
            'shop_id' => Yii::t('app', 'Shop'),
            'btype' => Yii::t('app', 'ประเภทบิล'),
            'amount' => Yii::t('app', 'จำนวนเงิน'),
            'status' => Yii::t('app', 'สถานะบิล'),
            'shiping' => Yii::t('app', 'สถานะการส่งสินค้า'),
            'charge' => Yii::t('app', 'สถานะเก็บเงิน'),
            'bill_upload' => Yii::t('app', 'Bill Upload'),
            'remark' => Yii::t('app', 'หมายเหตุ'),
            'bill_type'=> Yii::t('app', 'ประเภทบิล'),
            'bill_date' => Yii::t('backend', 'วันที่'),
            'billtype'=> Yii::t('backend', 'ประเภท'),
            'bill_upload'=> Yii::t('backend', 'ไฟล์อัปโหลด'),
            'blog'=> Yii::t('backend', 'กล่อง'),
            'difficulty'=>'ความยาก',
            'affective_score'=>'คะแนนจิตพิสัย',
            'rstat'=>'สถานะการใช้งานบิล',
            'remark_id'=>'หมายเหตุ'
        ];
    }
    public  function getBilltypes(){
        return @$this->hasOne(BillType::className(), ['id' => 'bill_type']);
    }
    public  function getStatuss(){
        return @$this->hasOne(BillStatus::className(), ['id' => 'status']);
    }
    public  function getShippings(){
        return @$this->hasOne(BillStatusShipping::className(), ['id' => 'shiping']);
    }
    public  function getCharges(){
        return @$this->hasOne(search\BillStatusCharge::className(), ['id' => 'charge']);
    }
    
    public  function getUsers(){
        return @$this->hasOne(\common\modules\user\models\User::className(), ['id' => 'user_id']);
    }
    public  function getProfiles(){
        return @$this->hasOne(\common\modules\user\models\Profile::className(), ['user_id' => 'user_id']);
    }
    
    public  function getShipping(){
         $shiping = \appxq\sdii\utils\SDUtility::string2Array($this->shiping);
         $model = BillStatusShipping::find()->where(['id'=>$shiping])->all();
         $name = '';
         foreach($model as $v){
             $name .= "<label class='label label-info'>{$v['name']}</label> ";
         }
         return $name;
    }
}
