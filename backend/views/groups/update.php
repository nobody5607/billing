<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Groups */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Groups',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="groups-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
