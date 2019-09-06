<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BillChargers */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bill Chargers',
]) . ' ' . $model->bill_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Chargers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bill_id, 'url' => ['view', 'bill_id' => $model->bill_id, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-chargers-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
