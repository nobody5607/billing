<?php
namespace kongoon\c3js;
use yii\web\AssetBundle;

class D3Asset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/d3';
    public $js = [
        'd3.js',
    ];
    public $depends = ['yii\web\JqueryAsset'];
}
