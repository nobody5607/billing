<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BillStatusCharge */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bill Status Charge',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Status Charges'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-status-charge-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
