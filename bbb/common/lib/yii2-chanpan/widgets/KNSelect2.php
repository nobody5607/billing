<?php
namespace cpn\chanpan\widgets;
use yii\helpers\Html;
// use yii\helpers\Json;
class KNSelect2 extends \yii\base\Widget{
     
    public $minimumInputLength = 0;
    public $init_data = [];
    public $model='';
    public $field='';
    public $form = '';
    public $placeholder = '';
    public $url = '';
    public $options = []; 
    public $modal = '';
    public $addUrl = '';
    public $addId = '';
    
    
    public function init()
    {
        parent::init(); 
    }
    public function run()
    {  
        parent::run();
        $addon = [];
        if(\Yii::$app->user->can('billmanager')){
            $addon = [

                'append' => [
                    'content' => \yii\helpers\Html::button("<i class='fa fa-plus'></i>", [
                        'class' => 'btn btn-success btnMangePopup',
                        'id'=>$this->addId,
                        'title' => '',
                        'data-toggle' => 'tooltip'
                    ]),
                    'asButton' => true

                ],
            ];
        }else{
            $this->options['disabled'] = true;
        }

        //'disabled'=> \Yii::$app->user->can('billmanager')?false:true
        $html = '';
        $html .= $this->form->field($this->model, $this->field)->widget(\kartik\select2\Select2::className(), [
            'initValueText' => !empty($this->init_data) ? $this->init_data['name'] : [], //กำหนดค่าเริ่มต้น
            'options' => $this->options,//,['placeholder' => $this->placeholder],
            'language' => \Yii::$app->language,
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => $this->minimumInputLength, //ต้องพิมพ์อย่างน้อย 3 อักษร ajax จึงจะทำงาน
                'ajax' => [
                    'url' => $this->url,
                    'dataType' => 'json', //รูปแบบการอ่านคือ json
                    'data' => new \yii\web\JsExpression('function(params) { return {q:params.term};}')
                ],
                'escapeMarkup' => new \yii\web\JsExpression('function(markup) { return markup;}'),
                'templateResult' => new \yii\web\JsExpression('function(prefix){ return prefix.text;}'),
                'templateSelection' => new \yii\web\JsExpression('function(prefix) {return prefix.text;}'),
            ],
            'addon'=>$addon
        ]);
        $this->registerScript();
        return $html;
    }
    public function registerScript(){
        $view = $this->getView();
        
        $js="
            $('#{$this->addId}').on('click', function(){
                let url = '".$this->addUrl."';
                $('.modal').css('overflow', 'scroll');
                $('#".$this->modal." .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
                $('#".$this->modal."').modal('show')
                        .find('.modal-content')
                        .load(url);
                return false;
            });
        ";
        $view->registerJs($js);
    }
}
