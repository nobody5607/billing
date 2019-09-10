<?php
namespace kongoon\c3js;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

class C3JS extends Widget
{
    public $htmlOptions = [];
    public $setupOptions = [];
    public $options = [];

    public function run()
    {
        if(isset($this->htmlOptions['id'])){
            $this->id = $this->htmlOptions['id'];
        }else{
            $this->id = $this->htmlOptions['id'] = $this->getId();
        }
        echo Html::tag('div', '', $this->htmlOptions);

        if(is_string($this->options)){
            $this->options = Json::decode($this->options);
        }
        $this->registerAsset();
        parent::run();
    }

    protected function registerAsset()
    {
        D3Asset::register($this->view);
        C3JSAsset::register($this->view);

        $this->options = ArrayHelper::merge(['bindto' => '#'.$this->id], $this->options);

        $jsOptions = Json::encode($this->options);
        $setupOptions = Json::encode($this->setupOptions);
        $js = "var ".$this->id." = c3.generate(".$jsOptions.");";
        $key = __CLASS__ . '#' . $this->id;

        $this->view->registerJs($js, View::POS_READY, $key);
    }
}
