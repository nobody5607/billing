<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerShipping */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Customer Shipping',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customer Shippings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'groupcond' => $model->groupcond]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-shipping-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
