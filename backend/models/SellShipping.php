<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sell_shipping".
 *
 * @property string $groupcond
 * @property string $groupname
 * @property string $percent
 */
class SellShipping extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sell_shipping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['groupcond'], 'required'],
            [['groupcond'], 'string', 'max' => 50],
            [['groupname'], 'string', 'max' => 200],
            [['percent','percent_package'], 'string', 'max' => 10],
            [['groupcond'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'groupcond' => Yii::t('app', 'Groupcond'),
            'groupname' => Yii::t('app', 'Groupname'),
            'percent' => Yii::t('app', 'Factor'),
            'percent_package' => Yii::t('app', 'Factor พนักงานจัดของ'),
        ];
    }
}
