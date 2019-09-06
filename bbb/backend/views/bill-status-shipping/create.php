<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BillStatusShipping */

$this->title = Yii::t('app', 'Create Bill Status Shipping');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Status Shippings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-status-shipping-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
