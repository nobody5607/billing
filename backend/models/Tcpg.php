<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tcpg".
 *
 * @property int $id
 * @property string $treasury
 * @property string $percent_package
 * @property string $commission_package
 * @property string $token
 */
class Tcpg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tcpg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['treasury', 'percent_package', 'commission_package', 'token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'treasury' => Yii::t('app', 'Treasury'),
            'percent_package' => Yii::t('app', 'Percent Package'),
            'commission_package' => Yii::t('app', 'Commission Package'),
            'token' => Yii::t('app', 'Token'),
        ];
    }
}
