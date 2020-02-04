<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CustomerShipping */

$this->title = Yii::t('app', 'Create Customer Shipping');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customer Shippings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-shipping-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
