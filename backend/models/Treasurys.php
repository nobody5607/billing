<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "treasurys".
 *
 * @property int $id
 * @property string $name คลัง
 */
class Treasurys extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'treasurys';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['id'], 'integer'],
            [['name','factor'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'คลัง'),
        ];
    }
}
