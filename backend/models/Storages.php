<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "storages".
 *
 * @property int $id
 * @property string $name พื้นที่เก็บ
 */
class Storages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'storages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'พื้นที่เก็บ'),
        ];
    }
}
