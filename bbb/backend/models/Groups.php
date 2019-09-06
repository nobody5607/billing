<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "groups".
 *
 * @property int $id s
 * @property string $name ชื่อ กล่องที่
 * @property string $value ค่าเริ่มต้น
 * @property string $to เลขมากสุด
 * @property string $selecteds ถึงเลขไหน
 */
class Groups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'to'], 'string', 'max' => 255],
            [['value', 'selecteds'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 's'),
            'name' => Yii::t('app', 'ชื่อ กล่องที่'),
            'value' => Yii::t('app', 'ค่าเริ่มต้น'),
            'to' => Yii::t('app', 'เลขมากสุด'),
            'selecteds' => Yii::t('app', 'ถึงเลขไหน'),
        ];
    }
}
