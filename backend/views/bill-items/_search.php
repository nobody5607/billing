<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\BillItems */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="bill-items-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
//        'layout' => 'horizontal',
//        'fieldConfig' => [
//            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
//            'horizontalCssClasses' => [
//                'label' => 'col-sm-2',
//                'offset' => 'col-sm-offset-3',
//                'wrapper' => 'col-sm-6',
//                'error' => '',
//                'hint' => '',
//            ],
//        ],
    ]); ?>


    <div class="row">

        <div class="col-md-6">
            <?= $form->field($model, 'billref')->textInput(['placeholder'=>'ค้นหาจากชื่อบิล หรือ ชื่อลูกค้า']) ?>
        </div>
        <div class="col-md-3">
            <label>สถานะบิล</label>
            <?php
                echo kartik\select2\Select2::widget([
                'model' => $model,
                'attribute' => 'status',
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\BillStatus::find()
                    ->where('rstat not in(0,3)')->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => 'สถานะบิล',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]);
            ?>

        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6" style="margin-top:20px;">
                    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php // echo $form->field($model, 'btype') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'shiping') ?>

    <?php // echo $form->field($model, 'charge') ?>

    <?php // echo $form->field($model, 'bill_upload') ?>

    <?php // echo $form->field($model, 'remark') ?>



    <?php ActiveForm::end(); ?>

</div>
