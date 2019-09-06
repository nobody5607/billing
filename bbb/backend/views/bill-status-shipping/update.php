<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BillStatusShipping */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bill Status Shipping',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Status Shippings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-status-shipping-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
