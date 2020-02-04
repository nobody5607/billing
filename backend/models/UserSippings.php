<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_sippings".
 *
 * @property int $id
 * @property int $bill_id
 * @property int $user_id ผู้ใช้
 * @property int $parent_id
 * @property int $type
 * @property int $rstat
 * @property int $create_by
 * @property string $create_date
 * @property int $upddate_by
 * @property string $update_date
 */
class UserSippings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_sippings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['id', 'bill_id', 'user_id', 'parent_id', 'type', 'rstat', 'create_by', 'upddate_by'], 'integer'],
            [['create_date', 'update_date','percent','treasury','storage','bill_date'], 'safe'],
            [['id'], 'unique'],
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
            'user_id' => Yii::t('app', 'ผู้ใช้'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'type' => Yii::t('app', 'ประเภท'),
            'rstat' => Yii::t('app', 'Rstat'),
            'create_by' => Yii::t('app', 'Create By'),
            'create_date' => Yii::t('app', 'Create Date'),
            'upddate_by' => Yii::t('app', 'Upddate By'),
            'update_date' => Yii::t('app', 'Update Date'),
            'percent'=>'percent%',
            'treasury'=>'คลัง',
            'storage'=>'ที่เก็บ'
        ];
    }
}
