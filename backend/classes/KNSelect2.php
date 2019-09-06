<?php

namespace backend\classes;
class KNSelect2 {
    //put your code here
    /**
     * 
     * @param type $form
     * @param type $model
     * @param type $field ตัวอย่าง 'shop_id'
     * @param type $init_data ตัวอย่าง $init_data=['id'=>'', 'name'=>'xxx']
     * @param type $url 
     * @param type $placeholder ตัวอย่าง '-- เลือก Bill Shop --'
     * @param type $minimumInputLength พิมพ์กี่ตัวอักษรถึงจะทำงาน
     * @return render select2
     */
    public static function renderSelect2Single($form, $model, $field, $init_data=[], $url, $placeholder='', $minimumInputLength=0){
        return $form->field($model, $field)->widget(\kartik\select2\Select2::className(), [
            'initValueText' => !empty($init_data) ? $init_data['name'] : [], //กำหนดค่าเริ่มต้น
            'options' => ['placeholder' => $placeholder],
            'language' => \Yii::$app->language,
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => $minimumInputLength, //ต้องพิมพ์อย่างน้อย 3 อักษร ajax จึงจะทำงาน
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json', //รูปแบบการอ่านคือ json
                    'data' => new \yii\web\JsExpression('function(params) { return {q:params.term};}')
                ],
                'escapeMarkup' => new \yii\web\JsExpression('function(markup) { return markup;}'),
                'templateResult' => new \yii\web\JsExpression('function(prefix){ return prefix.text;}'),
                'templateSelection' => new \yii\web\JsExpression('function(prefix) {return prefix.text;}'),
            ],
            'addon' => [
                'append' => [
                    'content' => \yii\helpers\Html::button("<i class='fa fa-plus'></i>", [
                        'class' => 'btn btn-success btnMangePopup', 
                        'title' => 'Mark on map', 
                        'data-toggle' => 'tooltip'
                    ]),
                    'asButton' => true
                ] 
            ],
        ]);
    }//select2Single
}
