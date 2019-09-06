<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BillShop */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bill Shop',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Shops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-shop-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
