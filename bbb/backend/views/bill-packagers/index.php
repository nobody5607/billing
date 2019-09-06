<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\BillItems */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('bill', 'Packager');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('../site/_header'); ?>
<div class="row">
        <div class="col-md-12">
            <div style="background: #fff;margin:0 0 0 1px">
            <div class="box-header">
                <?= Html::encode($this->title) ?> 
                <div class="pull-right">

                </div>
            </div>
            <div class="box-body">    
                <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
                <?php Pjax::begin(['id' => 'bill-items-grid-pjax']); ?>
                <?=
                GridView::widget([
                    'id' => 'bill-items-grid',
                    /* 	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['bill-items/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-bill-items']). ' ' .
                      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['bill-items/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-bill-items', 'disabled'=>true]), */
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['style' => 'text-align: center;'],
                            'contentOptions' => ['style' => 'width:60px;text-align: center;'],
                        ], 
                        [
                            'format' => 'raw',
                            //'attribute'=>'bill_upload',
                            'value' => function($model) {
                                $storageUrl = \Yii::getAlias('@storageUrl');
                                $url = "{$storageUrl}/uploads/{$model->bill_upload}";
                                $img = Html::img($url, ['style' => 'width:50px;']);
                                return "<a href='{$url}' target='_BLANK' class='showImage'>{$img}</a>";
                            }
                        ],
                        
                        'bookno',
                        'billno',
                        //'billref',
                        //'shop_id',
                        // 'btype',
                        [
                            'attribute'=>'amount',
                            'value'=>function($model){
                            return isset($model->amount)?number_format($model->amount, 2):0;
                            }
                        ],
                           [
                                'format' => 'raw',
                                'attribute' => 'status',
                                'value' => function($model) {
                                    if ($model->status) {
                                        return isset($model->statuss->name) ? $model->statuss->name : '';
                                    }
                                },
                                'filter' => kartik\select2\Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'status',
                                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\search\BillStatus::find()->where('rstat not in(0,3)')->all(), 'id', 'name'),
                                    //'theme' => kartik\select2\Select2::THEME_BOOTSTRAP,
                                    'hideSearch' => false,
                                    'options' => [
                                        'placeholder' => 'เลือกสถานะบิล',
                                    ],
                                    'pluginOptions' => [
                                            'allowClear' => true,
                                    ],
                                ]),
                            ],
                            [
                                'format' => 'raw',
                                'attribute' => 'shiping',
                                'value' => function($model) {
                                    return $model->shipping; //isset($model->shiping)?$model->shippings->name:'';
                                },
                                'filter' => kartik\select2\Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'shiping',
                                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\search\BillStatusShipping::find()->where('rstat not in(0,3)')->all(), 'id', 'name'),
                                    //'theme' => kartik\select2\Select2::THEME_BOOTSTRAP,
                                    'hideSearch' => false,
                                    'options' => [
                                        'placeholder' => 'สถานะการส่งสินค้า',
                                    ],
                                    'pluginOptions' => [
                                            'allowClear' => true,
                                    ],
                                ]),        
                            ],
                            [
                                'format' => 'raw',
                                'attribute' => 'charge',
                                'value' => function($model) {
                                    return isset($model->charge) ? $model->charges->name : '';
                                },
                                'filter' => kartik\select2\Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'charge',
                                    'data' => \yii\helpers\ArrayHelper::map(\backend\models\search\BillStatusCharge::find()->where('rstat not in(0,3)')->all(), 'id', 'name'),
                                    //'theme' => kartik\select2\Select2::THEME_BOOTSTRAP,
                                    'hideSearch' => false,
                                    'options' => [
                                        'placeholder' => 'สถานะเก็บเงิน',
                                    ],
                                    'pluginOptions' => [
                                            'allowClear' => true,
                                    ],
                                ]),
                            ],      
                                [
                                   'headerOptions' => ['style' => 'width:100px'],
                                  'format'=>'raw',
                                  'label'=>'พนักงานจัดสินค้า',
                                  'value'=>function($model){
                                    $html = "";
                                    $package = \backend\models\BillPackagers::find()->where(['bill_id'=>$model->id])->all();
                                    foreach($package as $k=>$v){
                                        $html .= "<a href='#' title='{$v->profiles->name}'><i id='{$v['id']}' class='fa fa-user'></i></a> ";
                                    }
                                    return $html;   
                                  }
                                ],        
                                [
                                  'format'=>'raw',
                                  'label'=> Yii::t('app','จัดการบิล'),
                                  'value'=>function($model){
                                    return Html::a('จัดการบิล <i class="fa fa-arrow-right" aria-hidden="true"></i> ',['/bill-packagers/manage?bill_id='.$model->id], ['class'=>'btn btn-primary btn-xs']);
                                  }
                                ],
                    // 'remark',
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>

            </div>
            </div>    
        </div>
    </div>



                <?=
                ModalForm::widget([
                    'id' => 'modal-bill-items',
                    'options' => ['tabindex' => false],
                        //'size'=>'modal-lg',
                ]);
                ?>

<?php
\richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]);
?>
<script>
    $(".showImage").on('click', function () {
        let url = $(this).attr('href');
        window.open(url, '_BLANK');
        return false;
    }); 
</script>
<?php \richardfan\widget\JSRegister::end(); ?>