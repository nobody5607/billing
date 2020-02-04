<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customer_shipping".
 *
 * @property string $groupcond
 * @property string $groupname
 * @property string $percent
 * @property string $percent_package Factor พนักงานจัดของ
 */
class CustomerShipping extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_shipping';
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
            [['percent', 'percent_package'], 'string', 'max' => 10],
            [['groupcond'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'groupcond' => 'Groupcond',
            'groupname' => 'Groupname',
            'percent' => 'ค่า Factor จัดส่ง',
            'percent_package' => 'ค่า Factor จัดของ',
        ];
    }
}
