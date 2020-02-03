<?php


namespace backend\models;
use yii\base\Model;


class ReportCar extends Model
{
    public $stdate;
    public $endate;
    public $user_id;
    public function rules()
    {
        return [
            [['stdate', 'endate', 'user_id'], 'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'stdate'    => \Yii::t('app', 'วันที่เริ่มต้น'),
            'endate' => \Yii::t('app', 'วันที่สินสุด'),
            'user_id' => \Yii::t('app', 'พนักงาน'),
        ];
    }

    public function formName()
    {
        return 'report-car-form';
    }
}