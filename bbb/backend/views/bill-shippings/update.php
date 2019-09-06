<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BillShippings */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bill Shippings',
]) . ' ' . $model->bill_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Shippings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bill_id, 'url' => ['view', 'bill_id' => $model->bill_id, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-shippings-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
