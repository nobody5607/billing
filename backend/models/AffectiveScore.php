<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "affective_score".
 *
 * @property int $id
 * @property string $name รายการ
 * @property string $percent Percent %
 */
class AffectiveScore extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'affective_score';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','percent'],'required'],
            [['name', 'percent'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'รายการ'),
            'percent' => Yii::t('app', 'Percent %'),
        ];
    }
}
