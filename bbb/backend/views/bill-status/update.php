<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BillStatus */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bill Status',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
