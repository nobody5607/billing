<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Storages */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Storages',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Storages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storages-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
