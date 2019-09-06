<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SellShipping */

$this->title = Yii::t('app', 'Create Sell Shipping');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sell Shippings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sell-shipping-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
