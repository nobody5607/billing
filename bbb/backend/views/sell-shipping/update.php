<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SellShipping */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sell Shipping',
]) . ' ' . $model->groupcond;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sell Shippings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->groupcond, 'url' => ['view', 'id' => $model->groupcond]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sell-shipping-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
