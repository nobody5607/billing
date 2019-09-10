<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "difficultys".
 *
 * @property int $id
 * @property string $name ความยาก
 * @property int $percent เปอร์เซน
 */
class Difficultys extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'difficultys';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['percent'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'ความยาก'),
            'percent' => Yii::t('app', 'เปอร์เซน'),
        ];
    }
}
