<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BillType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bill Type',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
